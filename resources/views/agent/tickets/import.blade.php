@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary-custom"><i class="fa-solid fa-file-import me-2"></i>Attribution de Tickets</h5>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3">
                            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert alert-info border-0 bg-light text-muted small">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Le fichier doit être au format <strong>.csv, .xlsx ou .xls</strong> et contenir une colonne nommée <strong>code</strong>.
                    </div>

                    <form action="{{ route('agent.tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="revendeur_id" class="form-label fw-bold text-uppercase small text-muted">Revendeur Destinataire</label>
                            <select name="revendeur_id" id="revendeur_id" class="form-select bg-light border-0" required>
                                <option value="">Choisir un revendeur...</option>
                                @foreach($revendeurs as $revendeur)
                                    <option value="{{ $revendeur->id }}">
                                        {{ $revendeur->user->nom }} {{ $revendeur->user->prenom }} ({{ $revendeur->telephone }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Les tickets seront immédiatement ajoutés au stock de ce revendeur.</div>
                        </div>

                        <div class="mb-4">
                            <label for="type_ticket_id" class="form-label fw-bold text-uppercase small text-muted">Type de Ticket</label>
                            <select name="type_ticket_id" id="type_ticket_id" class="form-select bg-light border-0" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->nom }} ({{ $type->duree_minutes }} min)</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="fichier" class="form-label fw-bold text-uppercase small text-muted">Fichier Tickets</label>
                            <input type="file" class="form-control" name="fichier" id="fichier" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm fw-bold text-uppercase ls-1">
                                <i class="fa-solid fa-paper-plane me-2"></i>Lancer l'Attribution
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
