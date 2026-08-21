<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Conner\Tagging\Model\Tagged;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request){
        $validated = $request->validate([
            'search_key' => ['required', 'string', 'max:100'],
        ]);

        $searchKey = trim($validated['search_key']);

        if ($searchKey === '') {
            return redirect()->route('home')->with('error', 'Saisissez un terme de recherche.');
        }

        $like = '%' . $searchKey . '%';
        $tagLike = '%' . Str::slug($searchKey) . '%';
        $tagArticleIds = Tagged::query()
            ->where('taggable_type', (new Article)->getMorphClass())
            ->where(function ($query) use ($like, $tagLike) {
                $query->where('tag_name', 'like', $like)
                    ->orWhere('tag_slug', 'like', $tagLike);
            })
            ->pluck('taggable_id');

        $articles = Article::with(['category', 'author'])
            ->where('isActive', 1)
            ->where(function ($query) use ($like, $tagArticleIds) {
                $query->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereIn('id', $tagArticleIds);
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('Front.search', compact('articles', 'searchKey'));
    }
}
