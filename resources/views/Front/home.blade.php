@extends('Front.app')
@section('title', 'ActuInfos — L’actualité avec du recul')

@section('News_slider')
  @if($famous_articles->isNotEmpty())
    <section class="popular-hero" aria-label="Articles les plus lus">
      <div class="popular-slider" data-slider>
        @foreach($famous_articles->take(5) as $index => $headline)
          <article class="hero popular-slide {{ $index === 0 ? 'is-active' : '' }}" data-slide="{{ $index }}" style="background-image:url('{{ $headline->imageUrl() }}')" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
            <div class="hero-content">
              <span class="popular-kicker"><i class="fas fa-fire mr-1"></i> Les plus lus</span>
              <a class="hero-category" href="{{ route('category.article', $headline->category->slug) }}">{{ $headline->category->name }}</a>
              <h1><a href="{{ route('article.details', $headline->slug) }}">{{ $headline->title }}</a></h1>
              <p class="hero-summary">{{ Str::limit(strip_tags(html_entity_decode($headline->description)), 150) }}</p>
              <div class="hero-meta"><span>{{ $headline->created_at->isoFormat('D MMMM YYYY') }}</span><span><i class="far fa-eye mr-1"></i>{{ $headline->views }} lectures</span></div>
            </div>
          </article>
        @endforeach

        @if($famous_articles->count() > 1)
          <button class="slider-control slider-prev" type="button" data-slider-prev aria-label="Article le plus lu précédent"><i class="fas fa-chevron-left"></i></button>
          <button class="slider-control slider-next" type="button" data-slider-next aria-label="Article le plus lu suivant"><i class="fas fa-chevron-right"></i></button>
          <div class="slider-dots" role="tablist" aria-label="Choisir un article">
            @foreach($famous_articles->take(5) as $index => $headline)
              <button type="button" class="slider-dot {{ $index === 0 ? 'is-active' : '' }}" data-slide-to="{{ $index }}" aria-label="Afficher l’article {{ $index + 1 }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}"></button>
            @endforeach
          </div>
        @endif
      </div>
    </section>
  @endif
@endsection

@section('Featured_news')
  @if($famous_articles->isNotEmpty())
    <div style="margin-bottom:44px"><p class="eyebrow">À ne pas manquer</p><h2 class="section-heading">Les plus lus</h2>
      <div class="story-grid">
        @foreach($famous_articles->take(4) as $article)
          <article class="story-card"><a class="story-image" href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div class="story-body"><a class="article-category" href="{{ route('category.article', $article->category->slug) }}">{{ $article->category->name }}</a><h2><a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ Str::limit(strip_tags(html_entity_decode($article->description)), 120) }}</p><div class="story-foot"><span>{{ $article->created_at->isoFormat('D MMM YYYY') }}</span><span><i class="far fa-eye"></i> {{ $article->views }}</span></div></div></article>
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
          <article class="story-card"><a class="story-image" href="{{ route('article.details', $article->slug) }}"><img src="{{ $article->imageUrl() }}" alt=""></a><div class="story-body"><span class="article-category">{{ $category->name }}</span><h2><a href="{{ route('article.details', $article->slug) }}">{{ $article->title }}</a></h2><p>{{ Str::limit(strip_tags(html_entity_decode($article->description)), 120) }}</p><div class="story-foot"><span>{{ $article->author->name }}</span><span>{{ $article->comments->count() }} <i class="far fa-comment"></i></span></div></div></article>
        @endforeach
      </div></section>
    @endif
  @endforeach
@endsection

@push('styles')
<style>
  .popular-hero { margin-bottom:44px; }
  .popular-slider { position:relative; min-height:490px; border-radius:24px; overflow:hidden; background:#172033; }
  .popular-slide { position:absolute; inset:0; margin:0; opacity:0; visibility:hidden; transform:scale(1.015); transition:opacity .45s ease, transform .7s ease, visibility .45s; }
  .popular-slide.is-active { opacity:1; visibility:visible; transform:scale(1); z-index:1; }
  .popular-slide .hero-content { max-width:720px; }
  .popular-kicker { display:block; color:#ffd166; font-size:.75rem; font-weight:800; letter-spacing:.1em; text-transform:uppercase; margin-bottom:12px; }
  .hero-summary { color:#e7edf7; max-width:620px; margin:0 0 18px; font-size:.98rem; }
  .slider-control { position:absolute; top:50%; z-index:3; transform:translateY(-50%); width:42px; height:42px; border:1px solid rgba(255,255,255,.35); border-radius:50%; background:rgba(10,18,34,.55); color:#fff; display:grid; place-items:center; cursor:pointer; }
  .slider-control:hover { background:var(--accent); border-color:var(--accent); }
  .slider-prev { left:20px; }.slider-next { right:20px; }
  .slider-dots { position:absolute; z-index:3; bottom:22px; left:50%; transform:translateX(-50%); display:flex; gap:8px; }
  .slider-dot { width:9px; height:9px; padding:0; border:0; border-radius:50%; background:rgba(255,255,255,.55); cursor:pointer; }
  .slider-dot.is-active { width:25px; border-radius:8px; background:#fff; }
  @media(max-width:600px) { .popular-slider { min-height:380px; border-radius:16px; }.popular-slide { padding:25px; }.popular-slide h1 { font-size:2.15rem; }.slider-control { width:34px; height:34px; }.slider-prev { left:12px; }.slider-next { right:12px; }.hero-summary { font-size:.88rem; } }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-slider]').forEach(function (slider) {
      const slides = Array.from(slider.querySelectorAll('[data-slide]'));
      const dots = Array.from(slider.querySelectorAll('[data-slide-to]'));
      if (slides.length < 2) return;
      let current = 0;
      let timer;

      function showSlide(index) {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => {
          const active = slideIndex === current;
          slide.classList.toggle('is-active', active);
          slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        });
        dots.forEach((dot, dotIndex) => {
          const active = dotIndex === current;
          dot.classList.toggle('is-active', active);
          dot.setAttribute('aria-selected', active ? 'true' : 'false');
        });
      }

      function restart() {
        window.clearInterval(timer);
        timer = window.setInterval(() => showSlide(current + 1), 6000);
      }

      slider.querySelector('[data-slider-prev]').addEventListener('click', () => { showSlide(current - 1); restart(); });
      slider.querySelector('[data-slider-next]').addEventListener('click', () => { showSlide(current + 1); restart(); });
      dots.forEach((dot, index) => dot.addEventListener('click', () => { showSlide(index); restart(); }));
      slider.addEventListener('mouseenter', () => window.clearInterval(timer));
      slider.addEventListener('mouseleave', restart);
      restart();
    });
  });
</script>
@endpush
