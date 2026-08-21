@extends('Front.app')
@section('title', $article->title . ' — ActuInfos')
@section('Main_section')
  <article class="article-page">
    <img class="article-cover" src="{{ $article->imageUrl() }}" alt="">
    <div class="article-copy"><a class="article-category" href="{{ route('category.article', $article->category->slug) }}">{{ $article->category->name }}</a><h1>{{ $article->title }}</h1><div class="story-meta" style="color:var(--muted)"><span>{{ $article->created_at->isoFormat('D MMMM YYYY') }}</span><span>{{ $article->views }} lectures</span></div><p>{{ $article->description }}</p><div class="article-byline"><span>Par <strong>{{ $article->author->name }}</strong></span><span>{{ $article->comments->count() }} commentaire(s)</span></div></div>
  </article>
  @if($article->isSharable)<div style="margin:22px 0" class="sharethis-inline-share-buttons"></div>@endif
  @if($article->isComment)
    <section class="comments-section">
      <div class="comments-heading"><div><p class="eyebrow">La conversation</p><h2 class="section-heading">{{ $article->comments->count() }} commentaire(s)</h2></div><span class="comments-heading-icon"><i class="fas fa-comments"></i></span></div>
      @forelse($article->comments as $comment)
        <article class="comment-card"><div class="comment-avatar">{{ strtoupper(substr($comment->name, 0, 1)) }}</div><div class="comment-content"><div class="comment-meta"><strong>{{ $comment->name }}</strong><time>{{ $comment->created_at->isoFormat('D MMM YYYY') }}</time></div><p>{{ $comment->message }}</p></div></article>
      @empty
        <div class="empty-state"><i class="far fa-comment-dots"></i><p>Soyez le premier à partager votre point de vue.</p></div>
      @endforelse
    </section>
    <section class="comment-form-card"><div class="comment-form-heading"><span class="contact-icon"><i class="fas fa-pen"></i></span><div><p class="eyebrow">Votre avis compte</p><h2 class="section-heading">Laisser un commentaire</h2></div></div>@if(session('success'))<div class="notice notice-success"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>@endif
      @if($errors->any())<div class="notice notice-error"><i class="fas fa-exclamation-circle"></i><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
      <form action="{{ route('comment', $article->id) }}" method="POST" class="comment-form">@csrf<div class="comment-field-row"><div class="contact-field"><label for="name">Nom <span class="text-danger">*</span></label><input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Votre nom" required></div><div class="contact-field"><label for="email">E-mail <span class="text-danger">*</span></label><input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="vous@exemple.com" required></div></div><div class="contact-field"><label for="web_site">Site web <span class="optional-label">(facultatif)</span></label><input class="form-control" id="web_site" name="web_site" type="url" value="{{ old('web_site') }}" placeholder="https://votre-site.com"></div><div class="contact-field"><label for="message">Votre commentaire <span class="text-danger">*</span></label><textarea class="form-control" id="message" name="message" rows="5" placeholder="Partagez votre point de vue..." required>{{ old('message') }}</textarea></div><button class="btn-brand" type="submit">Publier le commentaire <i class="fas fa-arrow-right ml-2"></i></button></form>
    </section>
  @endif
@endsection

@push('styles')
<style>
  .comments-section { margin-top:38px; }.comments-heading { display:flex; justify-content:space-between; align-items:center; }.comments-heading .section-heading { margin-bottom:0; }.comments-heading-icon { width:42px; height:42px; display:grid; place-items:center; background:#f1f0ff; color:var(--brand); border-radius:12px; }.comment-card { display:flex; gap:14px; padding:18px 0; border-bottom:1px solid var(--line); }.comment-avatar { width:40px; height:40px; flex:0 0 auto; display:grid; place-items:center; border-radius:50%; background:var(--brand); color:#fff; font-weight:800; }.comment-content { min-width:0; }.comment-meta { display:flex; gap:10px; align-items:center; }.comment-meta time { color:var(--muted); font-size:.78rem; }.comment-content p { margin:6px 0 0; color:#475467; white-space:pre-line; }.comment-form-card { margin-top:30px; background:#fff; border:1px solid var(--line); border-radius:20px; padding:28px; }.comment-form-heading { display:flex; gap:13px; align-items:center; margin-bottom:22px; }.comment-form-heading .section-heading { margin-bottom:0; }.comment-form { display:grid; gap:17px; }.comment-field-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }.optional-label { color:var(--muted); font-weight:400; }.comment-form .btn-brand { justify-self:start; }.comments-section .empty-state i { font-size:1.7rem; color:var(--brand); }.comments-section .empty-state p { margin:8px 0 0; }.notice-error ul { margin:0; padding-left:18px; }@media(max-width:560px){.comment-form-card{padding:21px}.comment-field-row{grid-template-columns:1fr}.comment-meta{display:block}.comment-meta time{display:block;margin-top:2px}}
</style>
@endpush
