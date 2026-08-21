<div class="sidebar-panel"><p class="eyebrow">À la une</p><h2 class="section-heading">Dernières infos</h2>
  @foreach($global_recent_articles as $article)
    <article class="side-story"><a href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div><span class="article-category">{{ $article->category->name }}</span><h3><a href="{{ route('article.details', $article->slug) }}">{{ Str::limit($article->title, 55) }}</a></h3></div></article>
  @endforeach
</div>
@if($global_tags->isNotEmpty())<div class="sidebar-panel"><p class="eyebrow">Explorer</p><h2 class="section-heading">Thématiques</h2><div class="tag-cloud">@foreach($global_tags as $tag)<a href="{{ route('tag.articles', $tag->slug) }}">#{{ $tag->name }}</a>@endforeach</div></div>@endif
