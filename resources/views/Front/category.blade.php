@extends('Front.app')
@section('title', $category->name . ' — ActuInfos')
@section('Main_section')
  <p class="eyebrow">Catégorie</p><h1 class="section-heading" style="font-size:2.4rem">{{ $category->name }}</h1>
  @if($category->articles->isNotEmpty())<div class="story-grid">@foreach($category->articles as $article)<article class="story-card"><a class="story-image" href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div class="story-body"><span class="article-category">{{ $category->name }}</span><h2><a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ Str::limit(strip_tags(html_entity_decode($article->description)), 130) }}</p><div class="story-foot"><span>{{ $article->created_at->isoFormat('D MMM YYYY') }}</span><span><i class="far fa-eye"></i> {{ $article->views }}</span></div></div></article>@endforeach</div>@else<div class="empty-state">Aucun article n’est encore publié dans cette catégorie.</div>@endif
@endsection
