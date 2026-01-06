<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReglementRevendeur;
use Illuminate\Support\Facades\DB;

class ReglementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reglements = ReglementRevendeur::with(['revendeur', 'admin_receveur'])
            ->latest()
            ->paginate(15);

        return view('admin.reglements.index', compact('reglements'));
    }

    public function create()
    {
        $revendeurs = User::where('role_id', 2)->get();
        return view('admin.reglements.create', compact('revendeurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'revendeur_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:100',
            'mode_paiement' => 'required|string',
            'reference_preuve' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Enregistrer le règlement
            ReglementRevendeur::create([
                'revendeur_id' => $request->revendeur_id,
                'montant' => $request->montant,
                'mode_paiement' => $request->mode_paiement,
                'reference_preuve' => $request->reference_preuve,
                'recu_par' => auth()->id(),
            ]);

            // 2. Mettre à jour le solde du revendeur
            // Si le revendeur paie, il rembourse sa dette.
            // Solde = Argent dû à l'admin. Donc on décrémente le solde.
            $revendeurUser = User::with('revendeur')->findOrFail($request->revendeur_id);
            
            if ($revendeurUser->revendeur) {
                // On décrémente le solde (dette)
                $revendeurUser->revendeur->decrement('solde_actuel', $request->montant);
            }
        });

        return redirect()->route('admin.reglements.index')->with('success', 'Règlement enregistré avec succès.');
    }
}
