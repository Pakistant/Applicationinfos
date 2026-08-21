<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(string $tag): View
    {
        $articles = Article::withAnyTag([$tag])
            ->where('isActive', 1)
            ->latest()
            ->get();

        return view('Front.tag', compact('articles', 'tag'));
    }
}