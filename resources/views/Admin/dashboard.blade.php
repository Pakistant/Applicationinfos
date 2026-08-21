@extends('Admin.app')
@section('title', 'Tableau de bord')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8">
      <p class="text-muted mb-1">{{ $isAdmin ? 'Pilotage de la plateforme' : 'Votre espace éditorial' }}</p>
      <h3 class="page-title mt-0">Bonjour, {{ Auth::user()->name }}</h3>
    </div>
    <div class="col-sm-4 text-sm-right">
      <span class="badge badge-pill {{ $isAdmin ? 'badge-primary' : 'badge-info' }} px-3 py-2">
        <i class="fas {{ $isAdmin ? 'fa-shield-alt' : 'fa-pen-nib' }} mr-1"></i>
        {{ $isAdmin ? 'Administrateur' : 'Auteur' }}
      </span>
    </div>
  </div>
@endsection

@section('dashboard-content')
  <div class="row">
    <div class="col-xl-3 col-sm-6 col-12">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-2">Articles</p>
              <h2 class="mb-1">{{ $totalArticles }}</h2>
              <small class="text-muted">{{ $publishedArticles }} publié(s)</small>
            </div>
            <span class="text-primary"><i class="fas fa-newspaper fa-lg"></i></span>
          </div>
          <a href="{{ route('article.index') }}" class="small d-inline-block mt-3">Gérer les articles <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-2">Brouillons</p>
              <h2 class="mb-1">{{ $draftArticles }}</h2>
              <small class="text-muted">À finaliser</small>
            </div>
            <span class="text-warning"><i class="fas fa-file-alt fa-lg"></i></span>
          </div>
          <a href="{{ route('article.index') }}" class="small d-inline-block mt-3">Voir les articles <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-2">Commentaires</p>
              <h2 class="mb-1">{{ $comments }}</h2>
              <small class="text-muted">{{ $pendingComments }} en attente</small>
            </div>
            <span class="text-info"><i class="fas fa-comments fa-lg"></i></span>
          </div>
          <a href="{{ route('comment.index') }}" class="small d-inline-block mt-3">Modérer <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-2">{{ $isAdmin ? 'Catégories' : 'Statut' }}</p>
              <h2 class="mb-1">{{ $isAdmin ? $categories : 'Actif' }}</h2>
              <small class="text-muted">{{ $isAdmin ? $authors.' auteur(s)' : 'Compte éditeur' }}</small>
            </div>
            <span class="text-success"><i class="fas {{ $isAdmin ? 'fa-layer-group' : 'fa-check-circle' }} fa-lg"></i></span>
          </div>
          @if($isAdmin)
            <a href="{{ route('category.index') }}" class="small d-inline-block mt-3">Organiser <i class="fas fa-arrow-right ml-1"></i></a>
          @else
            <a href="{{ route('profile.edit') }}" class="small d-inline-block mt-3">Mon profil <i class="fas fa-arrow-right ml-1"></i></a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <div>
            <h4 class="card-title mb-1">Publications récentes</h4>
            <p class="text-muted mb-0 small">Les derniers contenus de {{ $isAdmin ? 'la plateforme' : 'votre espace' }}.</p>
          </div>
          <a href="{{ route('article.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Nouvel article</a>
        </div>
        <div class="card-body p-0">
          @if($articlesRecent->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    @if($isAdmin)<th>Auteur</th>@endif
                    <th>Statut</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($articlesRecent as $article)
                    <tr>
                      <td><a href="{{ route('article.show', $article) }}" class="font-weight-bold">{{ Str::limit($article->title, 48) }}</a><br><small class="text-muted">{{ $article->created_at->isoFormat('D MMM YYYY') }}</small></td>
                      <td>{{ optional($article->category)->name ?? 'Sans catégorie' }}</td>
                      @if($isAdmin)<td>{{ optional($article->author)->name ?? 'Inconnu' }}</td>@endif
                      <td><span class="badge badge-pill {{ $article->isActive ? 'badge-success' : 'badge-secondary' }}">{{ $article->isActive ? 'Publié' : 'Brouillon' }}</span></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-5">
              <i class="fas fa-newspaper fa-2x text-muted mb-3"></i>
              <p class="text-muted mb-3">Aucun article n’a encore été créé.</p>
              <a href="{{ route('article.create') }}" class="btn btn-outline-primary">Créer le premier article</a>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white"><h4 class="card-title mb-0">Accès rapides</h4></div>
        <div class="card-body">
          <a href="{{ route('article.create') }}" class="d-flex align-items-center text-dark mb-3"><span class="text-primary mr-3"><i class="fas fa-pen"></i></span><span>Rédiger un article</span><i class="fas fa-chevron-right ml-auto text-muted"></i></a>
          <a href="{{ route('comment.index') }}" class="d-flex align-items-center text-dark mb-3"><span class="text-info mr-3"><i class="fas fa-comments"></i></span><span>Gérer les commentaires</span><i class="fas fa-chevron-right ml-auto text-muted"></i></a>
          @if($isAdmin)
            <a href="{{ route('category.create') }}" class="d-flex align-items-center text-dark mb-3"><span class="text-success mr-3"><i class="fas fa-folder-plus"></i></span><span>Ajouter une catégorie</span><i class="fas fa-chevron-right ml-auto text-muted"></i></a>
            <a href="{{ route('author.create') }}" class="d-flex align-items-center text-dark mb-3"><span class="text-warning mr-3"><i class="fas fa-user-plus"></i></span><span>Ajouter un auteur</span><i class="fas fa-chevron-right ml-auto text-muted"></i></a>
            <a href="{{ route('setting.index') }}" class="d-flex align-items-center text-dark"><span class="text-secondary mr-3"><i class="fas fa-cog"></i></span><span>Paramètres du site</span><i class="fas fa-chevron-right ml-auto text-muted"></i></a>
          @else
            <a href="{{ route('profile.edit') }}" class="d-flex align-items-center text-dark"><span class="text-secondary mr-3"><i class="fas fa-user-cog"></i></span><span>Modifier mon profil</span><i class="fas fa-chevron-right ml-auto text-muted"></i></a>
          @endif
        </div>
      </div>

      @if($isAdmin)
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <p class="text-muted mb-1">Messages reçus</p>
            <h3 class="mb-2">{{ $contacts }}</h3>
            <a href="{{ route('contact.index') }}" class="small">Consulter les contacts <i class="fas fa-arrow-right ml-1"></i></a>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
