<div class="sidebar-panel"><p class="eyebrow">À la une</p><h2 class="section-heading">Dernières infos</h2>
  @foreach($global_recent_articles as $article)
    <article class="side-story"><a href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div><span class="article-category">{{ $article->category->name }}</span><h3><a href="{{ route('article.details', $article->slug) }}">{{ Str::limit($article->title, 55) }}</a></h3></div></article>
  @endforeach
</div>
@if(($global_kiosk_issues ?? collect())->isNotEmpty())
  <div class="sidebar-panel kiosk-sidebar-panel">
    <p class="eyebrow">Éditions numériques</p><h2 class="section-heading">Derniers journaux</h2>
    @foreach($global_kiosk_issues as $issue)
      <article class="side-story kiosk-side-story">
        <a href="{{ route('kiosk.show', $issue) }}" aria-label="Consulter {{ $issue->title }}">
          @if($issue->coverUrl())<img src="{{ $issue->coverUrl() }}" alt="Couverture de {{ $issue->title }}">@else<div class="kiosk-pdf-mark"><i class="far fa-file-pdf"></i></div>@endif
        </a>
        <div><span class="article-category">Journal</span><h3><a href="{{ route('kiosk.show', $issue) }}">{{ Str::limit($issue->title, 42) }}</a></h3><small>{{ $issue->created_at->format('d/m/Y') }}</small></div>
      </article>
    @endforeach
    <a class="kiosk-sidebar-link" href="{{ route('kiosk.public') }}">Voir tous les journaux <i class="fas fa-arrow-right ml-1"></i></a>
  </div>
@endif
@if($global_tags->isNotEmpty())<div class="sidebar-panel"><p class="eyebrow">Explorer</p><h2 class="section-heading">Thématiques</h2><div class="tag-cloud">@foreach($global_tags as $tag)<a href="{{ route('tag.articles', $tag->slug) }}">#{{ $tag->name }}</a>@endforeach</div></div>@endif

<style>
  .kiosk-sidebar-panel .section-heading { margin-bottom: 8px; }
  .kiosk-side-story { grid-template-columns: 58px 1fr; gap: 11px; }
  .kiosk-side-story img, .kiosk-pdf-mark { width: 58px; height: 68px; border-radius: 8px; }
  .kiosk-pdf-mark { display: grid; place-items: center; background: #101827; color: #fff; font-size: 1.35rem; }
  .kiosk-side-story h3 { margin-top: 3px; }
  .kiosk-side-story small { color: var(--muted); font-size: .72rem; }
  .kiosk-sidebar-link { display: inline-block; margin-top: 16px; color: var(--brand); font-size: .8rem; font-weight: 700; }
</style>
