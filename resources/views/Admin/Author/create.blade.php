@extends('Admin.app')
@section('title', isset($user) ? 'Modifier un auteur' : 'Ajouter un auteur')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8">
      <p class="text-muted mb-1">Équipe éditoriale</p>
      <h3 class="page-title mt-0">{{ isset($user) ? 'Modifier l’auteur' : 'Nouvel auteur' }}</h3>
    </div>
    <div class="col-sm-4 text-sm-right">
      <a href="{{ route('author.index') }}" class="btn btn-light">Retour aux auteurs</a>
    </div>
  </div>
@endsection

@section('dashboard-content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <div class="mb-4">
            <h4 class="mb-1">Profil de l’auteur</h4>
            <p class="text-muted mb-0">Renseignez les informations utilisées dans les articles publiés.</p>
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

          <form action="{{ isset($user) ? route('author.update', $user) : route('author.store') }}" method="POST">
            @csrf
            @if (isset($user))
              @method('PUT')
            @endif

            <div class="form-group">
              <label for="author-name">Nom complet <span class="text-danger">*</span></label>
              <input id="author-name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Ex. Marie Dupont" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="author-email">Adresse email <span class="text-danger">*</span></label>
              <input id="author-email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="auteur@example.com" required>
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex align-items-center justify-content-between border-top pt-4 mt-4">
              <a href="{{ route('author.index') }}" class="text-muted">Annuler</a>
              <button type="submit" class="btn btn-primary px-4">{{ isset($user) ? 'Enregistrer les modifications' : 'Créer l’auteur' }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="card border-0 bg-light">
        <div class="card-body p-4">
          <h5><i class="fas fa-user-edit mr-2 text-primary"></i>Rôle de l’auteur</h5>
          <p class="text-muted mb-0">Un auteur peut rédiger et gérer ses publications depuis le tableau de bord. Les accès administrateur restent réservés au rôle admin.</p>
        </div>
      </div>
    </div>
  </div>
@endsection
