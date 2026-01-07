<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revendeur;
use App\Models\TypeTicket;
use App\Models\LotTicket;
use App\Imports\TicketsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function create()
    {
        $revendeurs = Revendeur::with('user')->get();
        $types = TypeTicket::all();
        return view('agent.tickets.import', compact('revendeurs', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fichier' => 'required|file|mimes:xls,xlsx,csv',
            'revendeur_id' => 'required|exists:revendeurs,id',
            'type_ticket_id' => 'required|exists:type_tickets,id',
        ]);

        // 1. Créer un Lot Virtuel pour l'import
        $numeroLot = 'IMPORT-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        
        $lot = LotTicket::create([
            'numero_lot' => $numeroLot,
            'type_ticket_id' => $request->type_ticket_id,
            'quantite' => 0, // Sera mis à jour après ou laissé indicateur
            'cree_par' => Auth::id(),
        ]);

        // 2. Récupérer l'ID utilisateur du revendeur (car Ticket::revendeur_actuel_id pointe vers users)
        $revendeur = Revendeur::findOrFail($request->revendeur_id);
        $revendeurUserId = $revendeur->utilisateur_id;

        // 3. Importer
        Excel::import(new TicketsImport($lot->id, $request->type_ticket_id, $revendeurUserId), $request->file('fichier'));

        // Mise à jour quantité (Approximatif si fichier gros, mais ok pour MVP)
        $count = $lot->tickets()->count();
        $lot->update(['quantite' => $count]);

        return redirect()->route('agent.tickets.import')->with('success', "$count Tickets attribués avec succès au revendeur !");
    }
}
