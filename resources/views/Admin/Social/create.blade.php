@extends('Admin.app')
@section('title', isset($social) ? 'Modifier un réseau social' : 'Ajouter un réseau social')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8">
      <p class="text-muted mb-1">Présence numérique</p>
      <h3 class="page-title mt-0">{{ isset($social) ? 'Modifier le réseau social' : 'Nouveau réseau social' }}</h3>
    </div>
    <div class="col-sm-4 text-sm-right">
      <a href="{{ route('social.index') }}" class="btn btn-light">Retour aux réseaux</a>
    </div>
  </div>
@endsection

@section('dashboard-content')
  <div class="row">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <div class="mb-4">
            <h4 class="mb-1">Ajouter un réseau</h4>
            <p class="text-muted mb-0">Saisissez le nom du réseau : son icône sera proposée automatiquement.</p>
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

          <form action="{{ isset($social) ? route('social.update', $social) : route('social.store') }}" method="POST">
            @csrf
            @if (isset($social))
              @method('PUT')
            @endif

            <div class="form-group">
              <label for="social-name">Nom du réseau <span class="text-danger">*</span></label>
              <input id="social-name" class="form-control @error('name') is-invalid @enderror" list="social-network-list" type="text" name="name" value="{{ old('name', $social->name ?? '') }}" placeholder="Ex. Facebook" autocomplete="off" required>
              <datalist id="social-network-list">
                <option value="Facebook">
                <option value="Instagram">
                <option value="X">
                <option value="YouTube">
                <option value="LinkedIn">
                <option value="TikTok">
                <option value="WhatsApp">
              </datalist>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="social-link">Lien du profil <span class="text-danger">*</span></label>
              <input id="social-link" class="form-control @error('link') is-invalid @enderror" type="url" name="link" value="{{ old('link', $social->link ?? '') }}" placeholder="https://www.facebook.com/votre-page" required>
              @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
              <label for="social-icon">Classe de l’icône</label>
              <div class="input-group">
                <input id="social-icon" class="form-control @error('icon') is-invalid @enderror" type="text" name="icon" value="{{ old('icon', $social->icon ?? '') }}" placeholder="fab fa-facebook-f" required>
                <div class="input-group-append">
                  <span class="input-group-text bg-white" style="min-width:52px; justify-content:center"><i id="social-icon-preview" class="{{ old('icon', $social->icon ?? 'fas fa-share-nodes') }}"></i></span>
                </div>
              </div>
              <small class="form-text text-muted">L’icône utilise Font Awesome. Vous pouvez modifier la classe manuellement.</small>
              @error('icon')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex align-items-center justify-content-between border-top pt-4 mt-4">
              <a href="{{ route('social.index') }}" class="text-muted">Annuler</a>
              <button type="submit" class="btn btn-primary px-4">{{ isset($social) ? 'Enregistrer les modifications' : 'Ajouter le réseau' }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="card border-0 bg-light">
        <div class="card-body p-4">
          <h5><i class="fas fa-icons mr-2 text-primary"></i>Aperçu automatique</h5>
          <p class="text-muted mb-3">Le nom du réseau détermine automatiquement la classe Font Awesome.</p>
          <div class="d-flex align-items-center">
            <span class="display-4 text-primary mr-3"><i id="social-icon-preview-large" class="{{ old('icon', $social->icon ?? 'fas fa-share-nodes') }}"></i></span>
            <span id="social-icon-label" class="font-weight-bold">{{ old('name', $social->name ?? 'Votre réseau') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const nameInput = document.getElementById('social-name');
      const iconInput = document.getElementById('social-icon');
      const iconPreview = document.getElementById('social-icon-preview');
      const iconPreviewLarge = document.getElementById('social-icon-preview-large');
      const iconLabel = document.getElementById('social-icon-label');
      const icons = {
        facebook: 'fab fa-facebook-f',
        instagram: 'fab fa-instagram',
        x: 'fab fa-x-twitter',
        twitter: 'fab fa-twitter',
        youtube: 'fab fa-youtube',
        linkedin: 'fab fa-linkedin-in',
        tiktok: 'fab fa-tiktok',
        whatsapp: 'fab fa-whatsapp'
      };

      function updateIcon() {
        const name = nameInput.value.trim();
        const icon = icons[name.toLowerCase()] || iconInput.value || 'fas fa-share-nodes';
        iconInput.value = icon;
        iconPreview.className = icon;
        iconPreviewLarge.className = icon;
        iconLabel.textContent = name || 'Votre réseau';
      }

      nameInput.addEventListener('input', updateIcon);
      iconInput.addEventListener('input', function () {
        iconPreview.className = iconInput.value || 'fas fa-share-nodes';
        iconPreviewLarge.className = iconInput.value || 'fas fa-share-nodes';
      });
      updateIcon();
    });
  </script>
@endsection
