@extends('Front.app')
@section('title','Contact — ActuInfos')
@section('Main_section')
  <p class="eyebrow">Une question ?</p><h1 class="section-heading" style="font-size:2.4rem">Parlons de votre projet</h1>
  <div class="form-card">@if(session('success'))<div class="alert alert-success notice">{{ session('success') }}</div>@endif
    <p style="color:var(--muted)">Une information, une suggestion ou une collaboration ? Notre équipe vous répondra avec plaisir.</p>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin:25px 0;color:var(--muted);font-size:.9rem"><div><i class="fas fa-envelope" style="color:var(--brand)"></i><br>{{ optional($global_setting)->email }}</div><div><i class="fas fa-phone" style="color:var(--brand)"></i><br>{{ optional($global_setting)->phone }}</div><div><i class="fas fa-map-marker-alt" style="color:var(--brand)"></i><br>{{ optional($global_setting)->address }}</div></div>
    <form action="{{ route('contact.envoyer') }}" method="POST">@csrf<div class="form-row"><div class="col-md-6 form-group"><label>Nom</label><input class="form-control" name="name" value="{{ old('name') }}" required></div><div class="col-md-6 form-group"><label>E-mail</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div></div><div class="form-group"><label>Objet</label><input class="form-control" name="subject" value="{{ old('subject') }}" required></div><div class="form-group"><label>Message</label><textarea class="form-control" rows="6" name="message" required>{{ old('message') }}</textarea></div><button class="btn-brand" type="submit">Envoyer le message <i class="fas fa-arrow-right" style="margin-left:6px"></i></button></form>
  </div>
@endsection
