@extends('auth.auth-layout')

@section('title',"Renitialiser votre mot de passe")

@section('auth-form')
<h1 class="mb-3">Renitialiser votre mot de passe</h1>

<form action="{{ route('password.store') }}" method="POST">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ request()->route('token') }}">

    <!-- Email -->
    <div class="form-group">
        <input class="form-control" type="email" name="email" 
               value="{{ old('email', request()->email) }}" 
               placeholder="Email" required autofocus>
    </div>
    @error('email')
        <p class="text-red-500 mt-2">{{ $message }}</p>
    @enderror

    <!-- Password -->
    <div class="form-group">
        <input class="form-control" type="password" name="password" 
               placeholder="Nouveau mot de passe" required>
    </div>
    @error('password')
        <p class="text-red-500 mt-2">{{ $message }}</p>
    @enderror

    <!-- Confirm Password -->
    <div class="form-group">
        <input class="form-control" type="password" name="password_confirmation" 
               placeholder="Confirmer le mot de passe" required>
    </div>
    @error('password_confirmation')
        <p class="text-red-500 mt-2">{{ $message }}</p>
    @enderror

    <div class="form-group mb-0">
        <button class="btn btn-primary btn-block" type="submit">Réinitialiser le mot de passe</button>
    </div>
</form>

<div class="text-center dont-have">
    Vous avez déjà un compte? <a href="{{ route('login') }}">Se connecter</a>
</div>
@endsection
