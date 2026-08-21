@extends('Front.app')
@section('title', $issue->title . ' — Kiosque')
@section('Main_section')
  <p class="eyebrow">Kiosque</p><h1 class="section-heading" style="font-size:2.4rem">{{ $issue->title }}</h1><div class="d-flex justify-content-between align-items-center flex-wrap mb-3"><span class="text-muted">Publié le {{ $issue->created_at->isoFormat('D MMMM YYYY') }}</span><a class="btn-brand" href="{{ $issue->pdfUrl() }}" target="_blank" rel="noopener noreferrer"><i class="fas fa-download mr-2"></i>Télécharger le PDF</a></div><iframe src="{{ $issue->pdfUrl() }}" title="{{ $issue->title }}" style="width:100%;height:75vh;border:1px solid var(--line);background:#fff"></iframe>
@endsection