<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index(){

    $articles = Article::where('isActive',1)->orderBy('created_at','DESC')->limit(10)->get();
    $famous_articles = Article::where('isActive',1)->orderByDesc('views')->orderByDesc('created_at')->limit(10)->get();
    $categories = Category::where('isActive',1)->orderBy('created_at','DESC')->with('articles')->get();

    return view('Front.home', compact('articles','categories','famous_articles'));

}
}
