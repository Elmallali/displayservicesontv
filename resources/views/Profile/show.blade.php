@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">👤 Mon Profil</h5>
                    <a href="{{ route('home') }}" class="btn btn-light btn-sm">Retour</a>
                </div>

                <div class="card-body text-center">
                    {{-- Avatar --}}
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0044cc&color=fff&size=120"
                         class="rounded-circle mb-3 shadow" width="120" height="120" alt="avatar">

                    {{-- User Info --}}
                    <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>

                    <hr>

                    {{-- Action Buttons --}}
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary me-2">Modifier mes informations</a>
                    <a href="{{ route('profile.password.form') }}" class="btn btn-outline-secondary">Changer le mot de passe</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
