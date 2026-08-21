@extends('Front.app')
@section('title', 'ActuInfos — L’actualité avec du recul')

@section('News_slider')
  @if($articles->isNotEmpty())
    @php($headline = $articles->first())
    <article class="hero" style="background-image:url('{{ $headline->imageUrl() }}')">
      <div class="hero-content">
        <a class="hero-category" href="{{ route('category.article', $headline->category->slug) }}">{{ $headline->category->name }}</a>
        <h1><a href="{{ route('article.details', $headline->slug) }}">{{ $headline->title }}</a></h1>
        <div class="hero-meta"><span>{{ $headline->created_at->isoFormat('D MMMM YYYY') }}</span><span>{{ $headline->views }} lectures</span></div>
      </div>
    </article>
  @endif
@endsection

@section('Featured_news')
  @if($famous_articles->isNotEmpty())
    <div style="margin-bottom:44px"><p class="eyebrow">À ne pas manquer</p><h2 class="section-heading">Les plus lus</h2>
      <div class="story-grid">
        @foreach($famous_articles->take(4) as $article)
          <article class="story-card"><a class="story-image" href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div class="story-body"><a class="article-category" href="{{ route('category.article', $article->category->slug) }}">{{ $article->category->name }}</a><h2><a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ Str::limit($article->description, 120) }}</p><div class="story-foot"><span>{{ $article->created_at->isoFormat('D MMM YYYY') }}</span><span><i class="far fa-eye"></i> {{ $article->views }}</span></div></div></article>
        @endforeach
      </div>
    </div>
  @endif
@endsection

@section('Main_section')
  @foreach($categories as $category)
    @if($category->articles->isNotEmpty())
      <section style="margin-bottom:44px"><p class="eyebrow">Dossier</p><h2 class="section-heading">{{ $category->name }}</h2><div class="story-grid">
        @foreach($category->articles->take(4) as $article)
          <article class="story-card"><a class="story-image" href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div class="story-body"><span class="article-category">{{ $category->name }}</span><h2><a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ Str::limit($article->description, 120) }}</p><div class="story-foot"><span>{{ $article->author->name }}</span><span>{{ $article->comments->count() }} <i class="far fa-comment"></i></span></div></div></article>
        @endforeach
      </div></section>
    @endif
  @endforeach
@endsection
