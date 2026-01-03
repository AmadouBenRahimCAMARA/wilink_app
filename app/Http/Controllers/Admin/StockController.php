<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TypeTicket;
use App\Models\Revendeur;
use App\Models\Ticket;
use App\Services\StockService;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->ticketMiddleware();
        $this->stockService = $stockService;
    }

    private function ticketMiddleware() {
         $this->middleware('auth');
    }

    // Affiche le formulaire d'attribution
    public function create()
    {
        // On récupère uniquement les users qui ont le rôle Revendeur (id 2)
        $revendeurs = User::where('role_id', 2)->get(); 
        
        // On récupère les types de tickets et on compte combien on en a en STOCK CENTRAL
        $types = TypeTicket::where('actif', true)->get()->map(function($type) {
            $type->stock_central = Ticket::where('type_ticket_id', $type->id)
                                         ->whereNull('revendeur_actuel_id')
                                         ->where('statut', 'cree')
                                         ->count();
            return $type;
        });

        return view('admin.stock.create', compact('revendeurs', 'types'));
    }

    // Exécute le transfert
    public function store(Request $request)
    {
        $request->validate([
            'revendeur_id' => 'required|exists:users,id',
            'type_ticket_id' => 'required|exists:types_tickets,id',
            'quantite' => 'required|integer|min:1',
        ]);

        try {
            $revendeur = User::findOrFail($request->revendeur_id);
            
            $count = $this->stockService->attribuerMasse(
                $request->type_ticket_id,
                $request->quantite,
                auth()->user(),
                $revendeur
            );

            return redirect()->route('admin.stock.create')
                             ->with('success', "$count tickets attribués avec succès à " . $revendeur->name);

        } catch (\Exception $e) {
            return back()->with('error', "Erreur : " . $e->getMessage());
        }
    }
}
