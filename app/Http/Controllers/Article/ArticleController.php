<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      if(Auth::user()->role == 'admin'){


        $articles=Article::All();
    
    
    }else{
         
        $articles=Article::where('author_id', Auth::user()->id)->get();
    }


        return view('Admin.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Article.create', ['categories'=> Category::where('isActive',1)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
    $data = $request->validated();
        //dd($data);

    $image = null;
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $image = $request->file('image')->store('asset', 'public');
    
    }
    $tags=explode(',',$request->tags);




    $article=Article::create([
        'title'       => $data['title'],
        'description' => $data['description'],
        'isActive'    => $data['isActive'],
        'isComment'   => $data['isComment'],
        'isSharable'  => $data['isSharable'],
        'image'       => $image,
        'category_id' => $data['category_id'],
        'author_id'   => Auth::id(),
    ]);
    $article->tag($tags);
    return to_route('article.index')->with('success','Article ajouté avec succès');
}

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
         return view('Admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('Admin.article.create', [
        
            'article'=>$article,
            'categories'=> Category::where('isActive',1)->get()
        
        
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)


{
   // dd($article);
    $data = $request->validated();

    $image = $article->image;
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $image = $request->file('image')->store('asset', 'public');
    }

    // Tags
    $tags = explode(',', $request->tags);

    $article->update([
        'title'       => $data['title'],
        'description' => $data['description'],
        'isActive'    => $data['isActive'],
        'isComment'   => $data['isComment'],
        'isSharable'  => $data['isSharable'],
        'image'       => $image,
        'category_id' => $data['category_id'],
    ]);

    $article->tag($tags);

    return to_route('article.index')->with('success', 'Article modifié avec succès');
}

    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Article supprimé avec succès');
    }
}
