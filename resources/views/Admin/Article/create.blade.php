@extends('Admin.app')
@section('title', isset($article) ? 'Modifier un article' : 'Ajouter un article')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8">
      <p class="text-muted mb-1">Publication et rédaction</p>
      <h3 class="page-title mt-0">{{ isset($article) ? 'Modifier l’article' : 'Nouvel article' }}</h3>
    </div>
    <div class="col-sm-4 text-sm-right">
      <a href="{{ route('article.index') }}" class="btn btn-light">Retour aux articles</a>
    </div>
  </div>
@endsection

@section('dashboard-content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <div class="mb-4">
            <h4 class="mb-1">Contenu de l’article</h4>
            <p class="text-muted mb-0">Rédigez une publication claire, illustrée et facile à retrouver.</p>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>Vérifiez les champs suivants :</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ isset($article) ? route('article.update', $article) : route('article.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($article))
              @method('PUT')
            @endif

            <div class="form-group">
              <label for="article-title">Titre de l’article <span class="text-danger">*</span></label>
              <input id="article-title" class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title', $article->title ?? '') }}" placeholder="Ex. Les décisions importantes de la semaine" required>
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="article-category">Catégorie <span class="text-danger">*</span></label>
                <select id="article-category" class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                  <option value="">Choisir une catégorie</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                  @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="form-group col-md-6">
                <label for="article-image">Image principale</label>
                <div class="custom-file">
                  <input id="article-image" type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                  <label class="custom-file-label" for="article-image">Choisir une image</label>
                </div>
                <small class="form-text text-muted">JPG, JPEG ou PNG, 2 Mo maximum.</small>
                @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
              </div>
            </div>

            @if(isset($article) && $article->image)
              <div class="mb-4">
                <p class="small text-muted mb-2">Image actuelle</p>
                <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}" class="img-fluid rounded" style="max-height:220px; object-fit:cover;">
              </div>
            @endif

            <div class="form-group">
              <label for="article-description">Description <span class="text-danger">*</span></label>
              <textarea id="article-description" class="form-control summernote @error('description') is-invalid @enderror" rows="8" name="description" placeholder="Rédigez le contenu ou le résumé de l’article..." required>{{ old('description', $article->description ?? '') }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="article-tags">Tags</label>
              @if(isset($article) && $article->tags->isNotEmpty())
                <div class="mb-2">
                  @foreach ($article->tags as $tag)
                    <span class="badge badge-info mr-1">#{{ $tag->name }}</span>
                  @endforeach
                </div>
              @endif
              <input id="article-tags" type="text" class="form-control @error('tags') is-invalid @enderror" data-role="tagsinput" name="tags" value="{{ old('tags') }}" placeholder="politique, économie, société">
              <small class="form-text text-muted">Séparez les mots-clés par des virgules.</small>
              @error('tags')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="border-top pt-4 mt-4">
              <h5 class="mb-3">Options de publication</h5>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="article-active">Publication</label>
                  <select id="article-active" class="form-control" name="isActive">
                    <option value="1" @selected(old('isActive', $article->isActive ?? 1) == 1)>Publié</option>
                    <option value="0" @selected(old('isActive', $article->isActive ?? 1) == 0)>Brouillon</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="article-shareable">Partage</label>
                  <select id="article-shareable" class="form-control" name="isSharable">
                    <option value="1" @selected(old('isSharable', $article->isSharable ?? 1) == 1)>Autorisé</option>
                    <option value="0" @selected(old('isSharable', $article->isSharable ?? 1) == 0)>Désactivé</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="article-comments">Commentaires</label>
                  <select id="article-comments" class="form-control" name="isComment">
                    <option value="1" @selected(old('isComment', $article->isComment ?? 1) == 1)>Autorisés</option>
                    <option value="0" @selected(old('isComment', $article->isComment ?? 1) == 0)>Désactivés</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-between border-top pt-4 mt-2">
              <a href="{{ route('article.index') }}" class="text-muted">Annuler</a>
              <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary px-4 mr-2 article-preview-btn">Prévisualiser</button>
                <button type="submit" class="btn btn-primary px-4">{{ isset($article) ? 'Enregistrer les modifications' : 'Publier l’article' }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="articlePreviewModal" tabindex="-1" role="dialog" aria-labelledby="articlePreviewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header">
            <h5 class="modal-title" id="articlePreviewModalLabel">Aperçu de l’article</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <div class="mb-3 pb-3 border-bottom">
              <div class="text-uppercase text-muted small mb-2">Avant publication</div>
              <h2 id="article-preview-title" class="mb-2"></h2>
              <div id="article-preview-meta" class="text-muted small"></div>
            </div>
            <div id="article-preview-content" class="article-preview-body"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="card border-0 bg-light mb-4">
        <div class="card-body p-4">
          <h5><i class="fas fa-lightbulb mr-2 text-primary"></i>Conseils de rédaction</h5>
          <ul class="text-muted pl-3 mb-0">
            <li class="mb-2">Choisissez un titre précis.</li>
            <li class="mb-2">Ajoutez une image qui illustre le sujet.</li>
            <li>Utilisez quelques tags pertinents.</li>
          </ul>
        </div>
      </div>
      <div class="card border-0 bg-light">
        <div class="card-body p-4">
          <h5><i class="fas fa-shield-alt mr-2 text-primary"></i>Avant de publier</h5>
          <p class="text-muted mb-0">Un brouillon reste accessible dans le back-office, mais n’apparaît pas dans les listes publiques.</p>
        </div>
      </div>
    </div>
  </div>
@endsection
