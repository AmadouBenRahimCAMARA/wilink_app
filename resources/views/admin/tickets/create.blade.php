@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Générer un nouveau lot de tickets</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="type_ticket_id" class="form-label">Type de Ticket</label>
                            <select name="type_ticket_id" id="type_ticket_id" class="form-select" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->nom }} - {{ $type->prix_public }} FCFA ({{ $type->duree_minutes }} min)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantite" class="form-label">Quantité à générer</label>
                            <input type="number" class="form-control @error('quantite') is-invalid @enderror" 
                                   id="quantite" name="quantite" value="50" min="1" max="1000" required>
                            @error('quantite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nombre de codes uniques à créer (Max 1000 par lot).</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                Générer les tickets
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
