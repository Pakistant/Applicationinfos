@extends('Admin.app')
@section('title', isset($issue) ? 'Modifier un journal' : 'Ajouter un journal')

@section('dashboard-header')
  <div class="row align-items-center"><div class="col"><p class="text-muted mb-1">Éditions numériques</p><h3 class="page-title mt-0">{{ isset($issue) ? 'Modifier le journal' : 'Ajouter un journal' }}</h3></div><div class="col text-right"><a href="{{ route('kiosk.index') }}" class="btn btn-light">Retour au kiosque</a></div></div>
@endsection

@section('dashboard-content')
  <div class="row"><div class="col-lg-8"><div class="card"><div class="card-body p-4">
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ isset($issue) ? route('kiosk.update', $issue) : route('kiosk.store') }}" method="POST" enctype="multipart/form-data">@csrf @if(isset($issue)) @method('PUT') @endif
      <div class="form-group"><label for="kiosk-title">Titre du journal <span class="text-danger">*</span></label><input id="kiosk-title" class="form-control" name="title" value="{{ old('title', $issue->title ?? '') }}" placeholder="Ex. Le journal du mois de septembre" required></div>
      <div class="form-group"><label for="kiosk-pdf">Fichier PDF <span class="text-danger">{{ isset($issue) ? '' : '*' }}</span></label><input id="kiosk-pdf" class="form-control-file" type="file" name="pdf" accept="application/pdf" {{ isset($issue) ? '' : 'required' }}><small class="form-text text-muted">PDF uniquement, 20 Mo maximum. {{ isset($issue) ? 'Laissez vide pour conserver le fichier actuel.' : '' }}</small></div>
      <div class="form-group"><label for="kiosk-cover">Couverture</label><input id="kiosk-cover" class="form-control-file" type="file" name="cover" accept="image/jpeg,image/png,image/webp"><small class="form-text text-muted">JPG, PNG ou WEBP, 2 Mo maximum.</small></div>
      <div class="form-group"><label for="kiosk-active">Visibilité</label><select id="kiosk-active" class="form-control" name="isActive"><option value="1" @selected(old('isActive', $issue->isActive ?? 1) == 1)>Publié dans le kiosque</option><option value="0" @selected(old('isActive', $issue->isActive ?? 1) == 0)>Brouillon</option></select></div>
      <div class="border-top pt-3 mt-4 d-flex justify-content-between"><a href="{{ route('kiosk.index') }}" class="text-muted">Annuler</a><button class="btn btn-primary" type="submit">{{ isset($issue) ? 'Enregistrer' : 'Ajouter au kiosque' }}</button></div>
    </form>
  </div></div></div></div>
@endsection