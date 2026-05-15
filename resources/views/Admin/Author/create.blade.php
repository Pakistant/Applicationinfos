@extends('Admin.app')
@yield('title',"Dashboard - Page des auteurs")

@section('dashboard-header')
 <div class="row align-items-center">
    <div class="col">
        <h3 class="page-title mt-5">
            @if (isset($user)) Modifier @else Ajouter @endif l'auteur
        </h3>
    </div>
</div>
@endsection

@section('dashboard-content')
<div class="row">
    <div class="col-lg-12">
        <form action="{{ isset($user) ? route('author.update', $user) : route('author.store') }}" method="POST">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif

            <div class="row formtype">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nom</label>
                        <input
                            class="form-control"
                            type="text"
                            name="name"
                            value="{{ isset($user) ? old('name', $user->name) : old('name') }}"
                        />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        <input
                            class="form-control"
                            type="email"
                            name="email"
                            value="{{ isset($user) ? old('email', $user->email) : old('email') }}"
                        />
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary buttonedit ml-2">
                Enregistrer
            </button>
        </form>
    </div>
</div>
@endsection
