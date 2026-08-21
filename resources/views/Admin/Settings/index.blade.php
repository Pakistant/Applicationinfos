@extends('Admin.app')
@section('title', 'Paramètres du site')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8">
      <p class="text-muted mb-1">Configuration générale</p>
      <h3 class="page-title mt-0">Paramètres du site</h3>
    </div>
    <div class="col-sm-4 text-sm-right">
      <span class="badge badge-pill badge-light px-3 py-2"><i class="fas fa-sliders-h mr-1"></i>Administration</span>
    </div>
  </div>
@endsection

@section('dashboard-content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <div class="mb-4">
            <h4 class="mb-1">Identité et coordonnées</h4>
            <p class="text-muted mb-0">Ces informations sont utilisées sur le site public et dans le pied de page.</p>
          </div>

          @if (session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <strong>La sauvegarde nécessite votre attention :</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form id="settings-form" action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="site-name">Nom du site <span class="text-danger">*</span></label>
              <input id="site-name" class="form-control @error('web_site_name') is-invalid @enderror" type="text" name="web_site_name" value="{{ old('web_site_name', $settings->web_site_name ?? '') }}" placeholder="Actupolitique" required>
              @error('web_site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="site-about">Présentation du site <span class="text-danger">*</span></label>
              <textarea id="site-about" class="form-control @error('about') is-invalid @enderror" rows="5" name="about" placeholder="Présentez votre média en quelques phrases..." required>{{ old('about', $settings->about ?? '') }}</textarea>
              @error('about')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="border-top pt-4 mt-4">
              <h5 class="mb-3">Coordonnées publiques</h5>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="site-address">Adresse</label>
                  <input id="site-address" class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address', $settings->address ?? '') }}" placeholder="Ville, pays">
                  @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                  <label for="site-phone">Téléphone</label>
                  <input id="site-phone" class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone', $settings->phone ?? '') }}" placeholder="+237 ...">
                  @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>
              <div class="form-group mb-0">
                <label for="site-email">Email public</label>
                <input id="site-email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $settings->email ?? '') }}" placeholder="contact@example.com">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-between border-top pt-4 mt-4">
              <span class="text-muted small"><i class="fas fa-lock mr-1"></i>Visible par les visiteurs</span>
              <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save mr-2"></i>Enregistrer les paramètres</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <h5 class="mb-3"><i class="fas fa-image mr-2 text-primary"></i>Logo du site</h5>
          @if(!empty($settings?->logo))
            <div class="text-center mb-3 p-3 bg-light rounded">
              <img src="{{ Storage::url($settings->logo) }}" alt="Logo actuel" class="img-fluid" style="max-height:120px; object-fit:contain;">
            </div>
          @else
            <div class="text-center text-muted py-4 bg-light rounded mb-3"><i class="fas fa-image fa-2x mb-2"></i><p class="mb-0 small">Aucun logo enregistré</p></div>
          @endif
          <label for="site-logo" class="font-weight-bold">Remplacer le logo</label>
          <div class="custom-file">
            <input id="site-logo" type="file" class="custom-file-input @error('logo') is-invalid @enderror" name="logo" accept=".jpg,.jpeg,.png" form="settings-form">
            <label class="custom-file-label" for="site-logo">Choisir une image</label>
          </div>
          <small class="form-text text-muted">PNG, JPG ou JPEG, 2 Mo maximum.</small>
          @error('logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="card border-0 bg-light">
        <div class="card-body p-4">
          <h5><i class="fas fa-info-circle mr-2 text-primary"></i>À savoir</h5>
          <p class="text-muted mb-0">Les changements sont appliqués immédiatement sur la page d’accueil et dans le pied de page. Le logo est stocké dans l’espace public Laravel.</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form[action="{{ route('setting.update') }}"]');
      const logoInput = document.getElementById('site-logo');
      if (logoInput) {
        logoInput.addEventListener('change', function () {
          const label = document.querySelector('label[for="site-logo"] + .custom-file .custom-file-label');
          if (label && this.files.length) label.textContent = this.files[0].name;
        });
      }
    });
  </script>
@endsection
