<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class DetailsController extends Controller
{
    public function index(String $slug){

        $article = Article::where('slug',$slug)->with('comments')->first();
        
        // Vérifier si l'article existe
        if (!$article) {
            abort(404, 'Article non trouvé');
        }
        
        $new_view= $article->views + 1;
        $article->views = $new_view;
        $article->update();

        // Récupérer les articles récents pour la sidebar
        $recent_articles = Article::where('isActive',1)
            ->where('id', '!=', $article->id) // Exclure l'article actuel
            ->orderBy('created_at','DESC')
            ->limit(5)
            ->get();

        return view('Front.details', compact('article', 'recent_articles'));
    }

    public function comment(StoreCommentRequest $request , int $id){

        // Vérifier que l'article existe
        $article = Article::find($id);
        if (!$article) {
            return back()->with('error', 'Article non trouvé');
        }

        Comment::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'web_site'=>$request->web_site,
            'message'=>$request->message,
            'article_id'=>$id,
        ]);

        return back()->with('success','Commentaire envoyé avec succès');
    }
}
