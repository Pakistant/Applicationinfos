@extends('Admin.app')
@section('title', isset($category) ? 'Modifier une catégorie' : 'Ajouter une catégorie')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8">
      <p class="text-muted mb-1">Organisation du contenu</p>
      <h3 class="page-title mt-0">{{ isset($category) ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}</h3>
    </div>
    <div class="col-sm-4 text-sm-right">
      <a href="{{ route('category.index') }}" class="btn btn-light">Retour aux catégories</a>
    </div>
  </div>
@endsection

@section('dashboard-content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <div class="mb-4">
            <h4 class="mb-1">Informations de la catégorie</h4>
            <p class="text-muted mb-0">Donnez un nom clair pour faciliter la navigation des lecteurs.</p>
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

          <form action="{{ isset($category) ? route('category.update', $category) : route('category.store') }}" method="POST">
            @csrf
            @if (isset($category))
              @method('PUT')
            @endif

            <div class="form-group">
              <label for="category-name">Nom de la catégorie <span class="text-danger">*</span></label>
              <input id="category-name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="Ex. Politique nationale" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="category-description">Description</label>
              <textarea id="category-description" class="form-control @error('description') is-invalid @enderror" rows="6" name="description" placeholder="Décrivez brièvement cette thématique...">{{ old('description', $category->description ?? '') }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group mb-4">
              <label for="category-status">Visibilité</label>
              <select id="category-status" class="form-control @error('isActive') is-invalid @enderror" name="isActive">
                <option value="1" @selected(old('isActive', $category->isActive ?? 1) == 1)>Visible sur le site</option>
                <option value="0" @selected(old('isActive', $category->isActive ?? 1) == 0)>Masquée du site</option>
              </select>
              @error('isActive')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex align-items-center justify-content-between border-top pt-4">
              <a href="{{ route('category.index') }}" class="text-muted">Annuler</a>
              <button type="submit" class="btn btn-primary px-4">{{ isset($category) ? 'Enregistrer les modifications' : 'Créer la catégorie' }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="card border-0 bg-light">
        <div class="card-body p-4">
          <h5><i class="fas fa-layer-group mr-2 text-primary"></i>Conseil éditorial</h5>
          <p class="text-muted mb-0">Utilisez des catégories courtes et distinctes. Une catégorie masquée reste enregistrée, mais n'apparaît plus dans la navigation publique.</p>
        </div>
      </div>
    </div>
  </div>
@endsection
