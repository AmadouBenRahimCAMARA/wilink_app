@extends('layouts.app')

@section('page-title', 'Mon Compte')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary-custom"><i class="fa-solid fa-user-pen me-2"></i>Mon Profil</h5>
                </div>

                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label text-muted small text-uppercase fw-bold">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                    <input id="nom" type="text" class="form-control border-start-0 bg-light @error('nom') is-invalid @enderror" 
                                           name="nom" value="{{ old('nom', $user->nom) }}" required autocomplete="family-name">
                                </div>
                                @error('nom')
                                    <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label text-muted small text-uppercase fw-bold">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                                    <input id="prenom" type="text" class="form-control border-start-0 bg-light @error('prenom') is-invalid @enderror" 
                                           name="prenom" value="{{ old('prenom', $user->prenom) }}" required autocomplete="given-name">
                                </div>
                                @error('prenom')
                                    <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label text-muted small text-uppercase fw-bold">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-phone"></i></span>
                                    <input id="telephone" type="text" class="form-control border-start-0 bg-light @error('telephone') is-invalid @enderror" 
                                           name="telephone" value="{{ old('telephone', $user->telephone) }}" required autocomplete="tel">
                                </div>
                                @error('telephone')
                                    <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label text-muted small text-uppercase fw-bold">Email (Lecture seule)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-envelope"></i></span>
                                    <input id="email" type="email" class="form-control border-start-0 bg-light" 
                                           value="{{ $user->email }}" disabled readonly>
                                </div>
                                <div class="form-text small">L'adresse email ne peut pas être modifiée.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary shadow fw-bold text-uppercase px-4">
                                <i class="fa-solid fa-save me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
