@extends('layouts.app')

@section('page-title', 'Gestion des Lots de Tickets')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Actions -->
        <div class="col-md-12 mb-4 text-end">
            <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Générer un Lot
            </a>
            <a href="{{ route('admin.stock.create') }}" class="btn btn-success shadow-sm ms-2">
                <i class="fa-solid fa-share-from-square me-2"></i>Attribuer Stock
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
            <div class="card card-pro">
                <div class="card-header-pro d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-table-list me-2"></i>Historique des Lots Générés</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Numéro Lot</th>
                                    <th>Type Ticket</th>
                                    <th>Quantité</th>
                                    <th>Généré le</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lots as $lot)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary-custom">{{ $lot->numero_lot }}</td>
                                        <td><span class="badge bg-info text-dark">{{ $lot->type_ticket->nom }}</span></td>
                                        <td>{{ $lot->quantite }}</td>
                                        <td>{{ $lot->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="fa-solid fa-download"></i> CSV
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">Aucun lot généré pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                 <div class="card-footer bg-white border-0">
                    {{ $lots->links() }}
                 </div>
            </div>
        </div>
    </div>
</div>
@endsection
