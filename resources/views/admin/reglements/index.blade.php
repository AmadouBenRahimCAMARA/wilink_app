@extends('layouts.app')

@section('page-title', 'Gestion des Règlements')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Actions -->
        <div class="col-md-12 mb-4 text-end">
            <a href="{{ route('admin.reglements.create') }}" class="btn btn-success shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Enregistrer un Paiement
            </a>
        </div>

        @if(session('success'))
            <div class="col-12">
                <div class="alert alert-success border-0 shadow-sm">
                     <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="card card-pro shadow-sm">
                <div class="card-header-pro d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-money-bill-wave me-2"></i>Historique des Paiements Revendeurs</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Date</th>
                                    <th>Revendeur</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Référence</th>
                                    <th>Reçu par</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reglements as $reglement)
                                    <tr>
                                        <td class="ps-4">{{ $reglement->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="fw-bold text-primary-custom">{{ $reglement->revendeur->name }}</td>
                                        <td class="text-success fw-bold">{{ number_format($reglement->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $reglement->mode_paiement }}</span>
                                        </td>
                                        <td>{{ $reglement->reference_preuve ?? '-' }}</td>
                                        <td class="small text-muted">{{ $reglement->admin_receveur->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-file-invoice-dollar fa-2x mb-3 text-muted opacity-50"></i>
                                            <p>Aucun règlement enregistré pour le moment.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                 <div class="card-footer bg-white border-0">
                    {{ $reglements->links() }}
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
