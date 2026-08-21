<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = in_array('admin', explode(',', $user->role), true);
        $articleQuery = Article::query();

        if (! $isAdmin) {
            $articleQuery->where('author_id', $user->id);
        }

        $articleIds = (clone $articleQuery)->pluck('id');
        $articlesRecent = (clone $articleQuery)
            ->with(['category', 'author'])
            ->latest()
            ->take(8)
            ->get();

        return view('Admin.dashboard', [
            'isAdmin' => $isAdmin,
            'totalArticles' => (clone $articleQuery)->count(),
            'publishedArticles' => (clone $articleQuery)->where('isActive', 1)->count(),
            'draftArticles' => (clone $articleQuery)->where('isActive', 0)->count(),
            'categories' => Category::count(),
            'authors' => User::where('role', 'author')->count(),
            'comments' => Comment::whereIn('article_id', $articleIds)->count(),
            'pendingComments' => Comment::whereIn('article_id', $articleIds)->where('isActive', 0)->count(),
            'contacts' => contact::count(),
            'articlesRecent' => $articlesRecent,
        ]);
    }
}
