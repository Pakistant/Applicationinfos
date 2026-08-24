@extends('Front.app')

@section('title', 'Tag : '.$tag.' - ActuInfos')

@section('Main_section')
  <p class="eyebrow">Thématique</p>
  <h1 class="section-heading" style="font-size:2.4rem">#{{ $tag }}</h1>

  @if($articles->isNotEmpty())
    <div class="story-grid">
      @foreach($articles as $article)
        <article class="story-card">
          <a class="story-image" href="{{ route('article.details', $article->slug) }}">
            <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}">
          </a>
          <div class="story-body">
            <a class="article-category" href="{{ route('category.article', $article->category->slug) }}">{{ $article->category->name }}</a>
            <h2><a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a></h2>
            <p>{{ Str::limit(strip_tags($article->description), 130) }}</p>
            <div class="story-foot">
              <span>{{ $article->author->name }}</span>
              <span>{{ $article->created_at->isoFormat('D MMM YYYY') }}</span>
            </div>
          </div>
        </article>
      @endforeach
    </div>
  @else
    <div class="empty-state">
      <i class="fas fa-tags" style="font-size:1.8rem;color:var(--brand)"></i>
      <p style="margin:10px 0 0">Aucun article trouvé pour ce tag.</p>
    </div>
  @endif
@endsection