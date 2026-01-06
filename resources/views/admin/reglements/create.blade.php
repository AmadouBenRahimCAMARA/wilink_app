@extends('layouts.app')

@section('page-title', 'Enregistrer un Règlement')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-pro shadow-sm">
                <div class="card-header-pro">
                    <i class="fa-solid fa-hand-holding-dollar me-2"></i>Nouveau Paiement Revendeur
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.reglements.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="revendeur_id" class="form-label text-muted text-uppercase fw-bold small">Revendeur</label>
                            <select name="revendeur_id" id="revendeur_id" class="form-select" required>
                                <option value="">Selectionner un revendeur...</option>
                                @foreach($revendeurs as $revendeur)
                                    <option value="{{ $revendeur->id }}">
                                        {{ $revendeur->name }} (Solde Actuel: {{ number_format($revendeur->revendeur->solde_actuel ?? 0, 0, ',', ' ') }} FCFA)
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Le solde actuel représente la dette du revendeur envers l'admin.</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="montant" class="form-label text-muted text-uppercase fw-bold small">Montant (FCFA)</label>
                                <input type="number" name="montant" id="montant" class="form-control" required min="100" placeholder="Ex: 50000">
                            </div>
                            <div class="col-md-6">
                                <label for="mode_paiement" class="form-label text-muted text-uppercase fw-bold small">Mode de Paiement</label>
                                <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                                    <option value="Espece">Espèces</option>
                                    <option value="OrangeMoney">Orange Money</option>
                                    <option value="MoovMoney">Moov Money</option>
                                    <option value="Virement">Virement Bancaire</option>
                                    <option value="Cheque">Chèque</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="reference_preuve" class="form-label text-muted text-uppercase fw-bold small">Référence / Preuve (Optionnel)</label>
                            <input type="text" name="reference_preuve" id="reference_preuve" class="form-control" placeholder="Numéro transaction, N° Chèque...">
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.reglements.index') }}" class="btn btn-light me-2">Annuler</a>
                            <button type="submit" class="btn btn-success fw-bold text-uppercase px-4">
                                <i class="fa-solid fa-check me-2"></i> Enregistrer le Paiement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
