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


        return view('Admin.Article.index', compact('articles'));
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
        'description' => $this->sanitizeDescription($data['description']),
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
         return view('Admin.Article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('Admin.Article.create', [
        
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
        'description' => $this->sanitizeDescription($data['description']),
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

    private function sanitizeDescription(string $html): string
    {
        $allowedTags = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'ul', 'ol', 'li', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'a'];
        $document = new \DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $clean = function (\DOMNode $node) use (&$clean, $allowedTags): void {
            foreach (iterator_to_array($node->childNodes) as $child) {
                if ($child instanceof \DOMElement) {
                    $tag = strtolower($child->tagName);
                    if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                        $child->parentNode->removeChild($child);
                        continue;
                    }
                    if (!in_array($tag, $allowedTags, true)) {
                        while ($child->firstChild) {
                            $child->parentNode->insertBefore($child->firstChild, $child);
                        }
                        $child->parentNode->removeChild($child);
                        continue;
                    }
                    $style = $child->getAttribute('style');
                    $href = $child->getAttribute('href');
                    for ($index = $child->attributes->length - 1; $index >= 0; $index--) {
                        $child->removeAttributeNode($child->attributes->item($index));
                    }
                    if ($style !== '') {
                        preg_match_all('/(?:color|background-color|font-size|font-family|font-weight|font-style|text-decoration|text-align)\s*:\s*[-#(),.%\sa-zA-Z0-9]+/i', $style, $matches);
                        if ($matches[0] !== []) {
                            $child->setAttribute('style', implode('; ', $matches[0]));
                        }
                    }
                    if ($tag === 'a' && preg_match('/^(https?:\/\/|mailto:)/i', $href)) {
                        $child->setAttribute('href', $href);
                        $child->setAttribute('target', '_blank');
                        $child->setAttribute('rel', 'noopener noreferrer');
                    }
                    $clean($child);
                }
            }
        };

        $clean($document->documentElement);
        $result = '';
        foreach ($document->documentElement->childNodes as $child) {
            $result .= $document->saveHTML($child);
        }

        return $result;
    }
}
