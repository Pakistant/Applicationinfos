@extends('Front.app')
@php($contactSiteName = optional($global_setting)->web_site_name ?: 'ActuInfos')
@section('title', 'Contact - '.$contactSiteName)

@section('Main_section')
  <div class="contact-page">
    <div class="contact-heading">
      <p class="eyebrow">Échangeons ensemble</p>
      <h1 class="section-heading contact-title">Nous contacter</h1>
      <p class="contact-lead">Une information, une suggestion ou une collaboration ? Notre équipe vous répondra avec plaisir.</p>
    </div>

    @if(session('success'))
      <div class="notice notice-success"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
    @endif

    @if($errors->any())
      <div class="notice notice-error"><i class="fas fa-exclamation-circle"></i><div><strong>Votre message n’a pas pu être envoyé.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>
    @endif

    <div class="contact-layout">
      <aside class="contact-info">
        <div class="contact-info-header"><span class="contact-icon"><i class="fas fa-paper-plane"></i></span><div><p class="eyebrow">Notre équipe</p><h2>Restons en contact</h2></div></div>
        <p class="contact-info-copy">Nous sommes à votre écoute pour vos questions, vos idées et vos propositions de collaboration.</p>

        <div class="contact-details">
          @if(optional($global_setting)->email)<a class="contact-detail" href="mailto:{{ $global_setting->email }}"><span><i class="fas fa-envelope"></i></span><div><small>Email</small><strong>{{ $global_setting->email }}</strong></div></a>@endif
          @if(optional($global_setting)->phone)<a class="contact-detail" href="tel:{{ $global_setting->phone }}"><span><i class="fas fa-phone-alt"></i></span><div><small>Téléphone</small><strong>{{ $global_setting->phone }}</strong></div></a>@endif
          @if(optional($global_setting)->address)<div class="contact-detail"><span><i class="fas fa-map-marker-alt"></i></span><div><small>Adresse</small><strong>{{ $global_setting->address }}</strong></div></div>@endif
        </div>

        @if(($global_social ?? collect())->isNotEmpty())
          <div class="contact-socials"><small>Suivez-nous</small><div>@foreach($global_social->take(5) as $social)<a href="{{ $social->link }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social->name }}" title="{{ $social->name }}"><i class="{{ $social->icon }}"></i></a>@endforeach</div></div>
        @endif
      </aside>

      <div class="contact-form-card">
        <div class="contact-form-header"><h2>Envoyez-nous un message</h2><p>Les champs marqués d’un <span class="text-danger">*</span> sont obligatoires.</p></div>
        <form action="{{ route('contact.envoyer') }}" method="POST" class="contact-form">
          @csrf
          <div class="contact-field-row">
            <div class="contact-field"><label for="contact-name">Nom complet <span class="text-danger">*</span></label><input id="contact-name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Votre nom" required>@error('name')<small class="field-error">{{ $message }}</small>@enderror</div>
            <div class="contact-field"><label for="contact-email">Adresse email <span class="text-danger">*</span></label><input id="contact-email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="vous@exemple.com" required>@error('email')<small class="field-error">{{ $message }}</small>@enderror</div>
          </div>
          <div class="contact-field"><label for="contact-subject">Objet</label><input id="contact-subject" class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" value="{{ old('subject') }}" placeholder="Le sujet de votre message">@error('subject')<small class="field-error">{{ $message }}</small>@enderror</div>
          <div class="contact-field"><label for="contact-message">Message <span class="text-danger">*</span></label><textarea id="contact-message" class="form-control @error('message') is-invalid @enderror" name="message" rows="7" placeholder="Écrivez votre message ici..." required>{{ old('message') }}</textarea>@error('message')<small class="field-error">{{ $message }}</small>@enderror</div>
          <div class="contact-submit"><span><i class="fas fa-lock mr-1"></i>Vos informations restent confidentielles</span><button class="btn-brand" type="submit">Envoyer le message <i class="fas fa-arrow-right ml-2"></i></button></div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('styles')
<style>
  .contact-page { max-width:100%; }
  .contact-title { font-size:clamp(2rem,4vw,3rem); margin-bottom:12px; }
  .contact-lead { max-width:690px; color:var(--muted); font-size:1.05rem; margin:0 0 28px; }
  .contact-layout { display:grid; grid-template-columns:minmax(230px,.72fr) minmax(0,1.45fr); gap:22px; align-items:stretch; }
  .contact-info,.contact-form-card { background:var(--surface); border:1px solid var(--line); border-radius:20px; padding:28px; box-shadow:0 10px 28px rgba(16,24,40,.04); }
  .contact-info { background:#101827; color:#fff; border-color:#101827; display:flex; flex-direction:column; }
  .contact-info-header { display:flex; gap:13px; align-items:center; }
  .contact-info-header .eyebrow { color:#ffd166; margin:0 0 3px; }
  .contact-info-header h2,.contact-form-header h2 { font:700 1.35rem 'Playfair Display',serif; margin:0; }
  .contact-icon { width:44px; height:44px; display:grid; place-items:center; border-radius:13px; background:var(--accent); color:#fff; }
  .contact-info-copy { color:#b9c5d6; font-size:.9rem; margin:25px 0; }
  .contact-details { display:grid; gap:18px; }
  .contact-detail { display:flex; align-items:center; gap:12px; color:#fff!important; }
  .contact-detail > span { width:34px; height:34px; display:grid; place-items:center; border:1px solid #39465b; border-radius:9px; color:#ffd166; font-size:.8rem; flex:0 0 auto; }
  .contact-detail div { min-width:0; display:flex; flex-direction:column; }
  .contact-detail small,.contact-socials small { color:#94a3b8; font-size:.7rem; text-transform:uppercase; letter-spacing:.08em; }
  .contact-detail strong { color:#f8fafc; font-size:.82rem; overflow-wrap:anywhere; }
  .contact-socials { border-top:1px solid #344258; margin-top:auto; padding-top:22px; }
  .contact-socials > div { display:flex; gap:8px; margin-top:10px; }
  .contact-socials a { width:32px; height:32px; display:grid; place-items:center; border:1px solid #39465b; border-radius:50%; color:#dbe4f0; font-size:.78rem; }
  .contact-socials a:hover { color:#fff; background:var(--accent); border-color:var(--accent); }
  .contact-form-header { border-bottom:1px solid var(--line); padding-bottom:18px; margin-bottom:22px; }
  .contact-form-header h2 { color:var(--ink); }.contact-form-header p { color:var(--muted); font-size:.82rem; margin:5px 0 0; }
  .contact-form { display:grid; gap:17px; }.contact-field-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }.contact-field label { display:block; color:var(--ink); font-size:.83rem; font-weight:700; margin-bottom:7px; }.contact-field .form-control { width:100%; }.contact-field textarea { resize:vertical; min-height:150px; }.field-error { display:block; color:#dc3545; margin-top:5px; }.contact-submit { display:flex; align-items:center; justify-content:space-between; gap:15px; border-top:1px solid var(--line); padding-top:18px; }.contact-submit > span { color:var(--muted); font-size:.72rem; }.contact-submit .btn-brand { white-space:nowrap; }
  .notice { display:flex; align-items:flex-start; gap:10px; padding:14px 16px; border-radius:12px; margin-bottom:20px; }.notice-success { background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; }.notice-error { background:#fff1f2; color:#9f1239; border:1px solid #fecdd3; }.notice ul { margin:4px 0 0; padding-left:18px; }
  @media(max-width:800px) { .contact-layout { grid-template-columns:1fr; }.contact-info { min-height:0; }.contact-socials { margin-top:25px; } }
  @media(max-width:560px) { .contact-info,.contact-form-card { padding:21px; border-radius:16px; }.contact-field-row { grid-template-columns:1fr; gap:17px; }.contact-submit { align-items:flex-start; flex-direction:column; }.contact-submit .btn-brand { width:100%; }.contact-title { font-size:2.1rem; } }
</style>
@endpush
