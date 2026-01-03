@extends('layouts.app')

@section('page-title', 'Attribution de Stock')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-pro">
                <div class="card-header-pro text-center">
                    <i class="fa-solid fa-truck-ramp-box fa-2x mb-2 text-success"></i>
                    <h5 class="mb-0">Transférer vers Revendeur</h5>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.stock.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="revendeur_id" class="form-label text-muted fw-bold">Revendeur Destinataire</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user"></i></span>
                                <select name="revendeur_id" id="revendeur_id" class="form-select border-start-0" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($revendeurs as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="type_ticket_id" class="form-label text-muted fw-bold">Type de Ticket</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-ticket"></i></span>
                                <select name="type_ticket_id" id="type_ticket_id" class="form-select border-start-0" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ $type->stock_central == 0 ? 'disabled' : '' }}>
                                            {{ $type->nom }} (Dispo: {{ $type->stock_central }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quantite" class="form-label text-muted fw-bold">Quantité à Transférer</label>
                            <input type="number" class="form-control" name="quantite" min="1" placeholder="Ex: 50" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg shadow-sm">
                                VALIDER LE TRANSFERT
                            </button>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-link text-muted">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
