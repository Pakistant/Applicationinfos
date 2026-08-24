@extends('Front.app')
@section('title', $article->title . ' — ActuInfos')
@section('Main_section')
  <article class="article-page">
    <img class="article-cover" src="{{ $article->imageUrl() }}" alt="">
    <div class="article-copy"><a class="article-category" href="{{ route('category.article', $article->category->slug) }}">{{ $article->category->name }}</a><h1>{{ $article->title }}</h1><div class="story-meta" style="color:var(--muted)"><span>{{ $article->created_at->isoFormat('D MMMM YYYY') }}</span><span>{{ $article->views }} lectures</span></div><div class="article-body">{!! $article->description !!}</div><div class="article-byline"><span>Par <strong>{{ $article->author->name }}</strong></span><span>{{ $article->comments->count() }} commentaire(s)</span></div></div>
  </article>
  @if($article->isSharable)
    <section class="article-share" aria-label="Partager cet article">
      <span><i class="fas fa-share-alt mr-2"></i>Partager cet article</span>
      <div class="article-share-actions">
        <a class="share-facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="Partager sur Facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a class="share-x" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" aria-label="Partager sur X" title="X"><i class="fab fa-x-twitter"></i></a>
        <a class="share-whatsapp" href="https://wa.me/?text={{ urlencode($article->title.' '.url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="Partager sur WhatsApp" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        <button class="share-copy" type="button" data-share-copy="{{ url()->current() }}" aria-label="Copier le lien" title="Copier le lien"><i class="fas fa-link"></i></button>
        <button class="share-native" type="button" data-share-native aria-label="Partager" title="Partager"><i class="fas fa-external-link-alt"></i></button>
      </div>
      <span class="share-feedback" data-share-feedback role="status" aria-live="polite"></span>
    </section>
  @endif
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

  @if($relatedArticles->isNotEmpty())
    <section class="related-articles" style="margin-top:40px;">
      <div class="comments-heading" style="margin-bottom:18px;">
        <div>
          <p class="eyebrow">Dans le même thème</p>
          <h2 class="section-heading">À lire aussi</h2>
        </div>
        <span class="comments-heading-icon"><i class="fas fa-newspaper"></i></span>
      </div>

      <div class="story-grid">
        @foreach($relatedArticles as $related)
          <article class="story-card">
            <a class="story-image" href="{{ route('article.details', $related->slug) }}">
              <img src="{{ $related->imageUrl() }}" alt="{{ $related->title }}">
            </a>
            <div class="story-body">
              <a class="article-category" href="{{ route('category.article', optional($related->category)->slug) }}">{{ optional($related->category)->name ?? 'Actualité' }}</a>
              <h2><a href="{{ route('article.details', $related->slug) }}">{{ $related->title }}</a></h2>
              <p>{{ Str::limit(strip_tags(html_entity_decode($related->description ?? '')), 130) }}</p>
              <div class="story-foot">
                <span>{{ optional($related->author)->name ?? 'Rédaction' }}</span>
                <span>{{ $related->created_at->isoFormat('D MMM YYYY') }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endif
@endsection

@push('styles')
<style>
  .comments-section { margin-top:38px; }.comments-heading { display:flex; justify-content:space-between; align-items:center; }.comments-heading .section-heading { margin-bottom:0; }.comments-heading-icon { width:42px; height:42px; display:grid; place-items:center; background:#f1f0ff; color:var(--brand); border-radius:12px; }.comment-card { display:flex; gap:14px; padding:18px 0; border-bottom:1px solid var(--line); }.comment-avatar { width:40px; height:40px; flex:0 0 auto; display:grid; place-items:center; border-radius:50%; background:var(--brand); color:#fff; font-weight:800; }.comment-content { min-width:0; }.comment-meta { display:flex; gap:10px; align-items:center; }.comment-meta time { color:var(--muted); font-size:.78rem; }.comment-content p { margin:6px 0 0; color:#475467; white-space:pre-line; }.comment-form-card { margin-top:30px; background:#fff; border:1px solid var(--line); border-radius:20px; padding:28px; }.comment-form-heading { display:flex; gap:13px; align-items:center; margin-bottom:22px; }.comment-form-heading .section-heading { margin-bottom:0; }.comment-form { display:grid; gap:17px; }.comment-field-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }.optional-label { color:var(--muted); font-weight:400; }.comment-form .btn-brand { justify-self:start; }.comments-section .empty-state i { font-size:1.7rem; color:var(--brand); }.comments-section .empty-state p { margin:8px 0 0; }.notice-error ul { margin:0; padding-left:18px; }@media(max-width:560px){.comment-form-card{padding:21px}.comment-field-row{grid-template-columns:1fr}.comment-meta{display:block}.comment-meta time{display:block;margin-top:2px}}
  .article-share { display:flex; align-items:center; gap:16px; flex-wrap:wrap; margin:22px 0 30px; padding:14px 18px; background:#fff; border:1px solid var(--line); border-radius:14px; color:var(--muted); font-size:.82rem; font-weight:700; }.article-share-actions { display:flex; gap:8px; }.article-share-actions a,.article-share-actions button { width:34px; height:34px; display:grid; place-items:center; border:0; border-radius:50%; color:#fff; cursor:pointer; transition:transform .2s ease,opacity .2s ease; }.article-share-actions a:hover,.article-share-actions button:hover { color:#fff; opacity:.85; transform:translateY(-2px); }.share-facebook { background:#1877f2; }.share-x { background:#111827; }.share-whatsapp { background:#25d366; }.share-copy { background:var(--brand); }.share-native { background:var(--accent); }.share-feedback { color:#198754; font-size:.75rem; font-weight:600; }.share-feedback:empty { display:none; }
  .related-articles .story-grid { grid-template-columns:repeat(3, minmax(0, 1fr)); gap:16px; }
  .related-articles .story-card { border-radius:16px; }
  .related-articles .story-image { height:170px; }
  .related-articles .story-body { padding:18px; }
  .related-articles .story-card h2 { font-size:1.08rem; line-height:1.3; margin-top:8px; }
  .related-articles .story-card p { font-size:0.84rem; }
  .related-articles .story-foot { padding-top:14px; font-size:0.72rem; }
  @media(max-width:991px){.related-articles .story-grid{grid-template-columns:repeat(2,minmax(0,1fr));}}@media(max-width:560px){.article-share{align-items:flex-start;flex-direction:column;gap:10px}.article-share-actions{width:100%;justify-content:flex-start}.related-articles .story-grid{grid-template-columns:1fr}}
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const feedback = document.querySelector('[data-share-feedback]');
    const pageUrl = '{{ url()->current() }}';
    const shareTitle = @json($article->title);
    const showFeedback = (message) => {
      if (!feedback) return;
      feedback.textContent = message;
      window.setTimeout(() => { feedback.textContent = ''; }, 2500);
    };

    document.querySelector('[data-share-copy]')?.addEventListener('click', async function () {
      try {
        await navigator.clipboard.writeText(this.dataset.shareCopy);
        showFeedback('Lien copié.');
      } catch (error) {
        showFeedback('Copie impossible, utilisez le bouton de partage.');
      }
    });

    document.querySelector('[data-share-native]')?.addEventListener('click', async function () {
      if (!navigator.share) {
        showFeedback('Le partage système n’est pas disponible sur cet appareil.');
        return;
      }
      try {
        await navigator.share({ title: shareTitle, url: pageUrl });
      } catch (error) {
        if (error.name !== 'AbortError') showFeedback('Partage impossible.');
      }
    });
  });
</script>
@endpush
