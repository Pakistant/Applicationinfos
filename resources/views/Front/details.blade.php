@extends('Front.app')
@section('title', $article->title . ' — ActuInfos')
@section('Main_section')
  <article class="article-page">
    <img class="article-cover" src="{{ $article->imageUrl() }}" alt="">
    <div class="article-copy"><a class="article-category" href="{{ route('category.article', $article->category->slug) }}">{{ $article->category->name }}</a><h1>{{ $article->title }}</h1><div class="story-meta" style="color:var(--muted)"><span>{{ $article->created_at->isoFormat('D MMMM YYYY') }}</span><span>{{ $article->views }} lectures</span></div><p>{{ $article->description }}</p><div class="article-byline"><span>Par <strong>{{ $article->author->name }}</strong></span><span>{{ $article->comments->count() }} commentaire(s)</span></div></div>
  </article>
  @if($article->isSharable)<div style="margin:22px 0" class="sharethis-inline-share-buttons"></div>@endif
  @if($article->isComment)
    <section style="margin-top:36px"><p class="eyebrow">Échanges</p><h2 class="section-heading">{{ $article->comments->count() }} commentaire(s)</h2>
      @forelse($article->comments as $comment)<div class="form-card" style="margin-bottom:12px;padding:20px"><strong>{{ $comment->name }}</strong><small style="color:var(--muted);margin-left:8px">{{ $comment->created_at->isoFormat('D MMM YYYY') }}</small><p style="margin:8px 0 0;color:var(--muted)">{{ $comment->message }}</p></div>@empty <div class="empty-state">Soyez le premier à partager votre point de vue.</div>@endforelse
    </section>
    <section class="form-card" style="margin-top:30px"><p class="eyebrow">Votre avis</p><h2 class="section-heading">Laisser un commentaire</h2>@if(session('success'))<div class="alert alert-success notice">{{ session('success') }}</div>@endif
      <form action="{{ route('comment', $article->id) }}" method="POST">@csrf<div class="form-row"><div class="col-md-6 form-group"><label for="name">Nom</label><input class="form-control" id="name" name="name" value="{{ old('name') }}" required></div><div class="col-md-6 form-group"><label for="email">E-mail</label><input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required></div></div><div class="form-group"><label for="web_site">Site web <span style="color:var(--muted);font-weight:400">(facultatif)</span></label><input class="form-control" id="web_site" name="web_site" type="url" value="{{ old('web_site') }}"></div><div class="form-group"><label for="message">Votre commentaire</label><textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea></div><button class="btn-brand" type="submit">Publier le commentaire</button></form>
    </section>
  @endif
@endsection
