@extends('Admin.app')
@section('title', 'Gestion du kiosque')

@section('dashboard-header')
  <div class="row align-items-center"><div class="col"><p class="text-muted mb-1">Éditions numériques</p><h3 class="page-title mt-0">Journaux en kiosque</h3></div><div class="col text-right"><a href="{{ route('kiosk.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Ajouter un journal</a></div></div>
@endsection

@section('dashboard-content')
  @if($issues->isNotEmpty())
    <div class="card card-table"><div class="card-body"><div class="table-responsive"><table class="table table-hover table-center mb-0"><thead><tr><th>Titre</th><th>Auteur</th><th>Ajouté le</th><th>Statut</th><th class="text-right">Actions</th></tr></thead><tbody>
      @foreach($issues as $issue)<tr><td><strong>{{ $issue->title }}</strong><br><small class="text-muted"><i class="far fa-file-pdf mr-1"></i>PDF disponible</small></td><td>{{ optional($issue->author)->name ?? 'Inconnu' }}</td><td>{{ $issue->created_at->format('d/m/Y') }}</td><td><span class="badge {{ $issue->isActive ? 'badge-success' : 'badge-secondary' }}">{{ $issue->isActive ? 'Publié' : 'Brouillon' }}</span></td><td class="text-right"><a href="{{ route('kiosk.show', $issue) }}" target="_blank" class="btn btn-sm btn-outline-primary mr-1" title="Consulter"><i class="fas fa-eye"></i></a><a href="{{ route('kiosk.edit', $issue) }}" class="btn btn-sm btn-outline-secondary mr-1" title="Modifier"><i class="fas fa-pen"></i></a><form action="{{ route('kiosk.destroy', $issue) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce journal ?');">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button></form></td></tr>@endforeach
    </tbody></table></div></div></div>
  @else
    <div class="card"><div class="card-body text-center py-5"><i class="fas fa-newspaper fa-2x text-muted mb-3"></i><h4>Aucun journal dans le kiosque</h4><p class="text-muted">Ajoutez votre première édition numérique.</p><a href="{{ route('kiosk.create') }}" class="btn btn-primary">Ajouter un journal</a></div></div>
  @endif
@endsection