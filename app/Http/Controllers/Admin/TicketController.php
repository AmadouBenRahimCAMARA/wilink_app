<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeTicket;
use App\Services\TicketService;
use App\Models\LotTicket;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->middleware('auth');
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $lots = LotTicket::with(['type_ticket', 'createur'])->latest()->paginate(10);
        return view('admin.tickets.index', compact('lots'));
    }

    public function create()
    {
        $types = TypeTicket::where('actif', true)->get();
        return view('admin.tickets.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_ticket_id' => 'required|exists:types_tickets,id',
            'quantite' => 'required|integer|min:1|max:1000',
        ]);

        $type = TypeTicket::findOrFail($request->type_ticket_id);
        
        $this->ticketService->genererLot(
            $type,
            $request->quantite,
            auth()->user()
        );

        return redirect()->route('admin.tickets.index')->with('success', 'Lot de tickets généré avec succès.');
    }

    public function downloadPdf($lot_id)
    {
        $lot = LotTicket::with(['tickets', 'type_ticket'])->findOrFail($lot_id);
        
        $pdf = \PDF::loadView('admin.tickets.pdf', compact('lot'));
        
        // Optionnel : definir le format papier (Ex: A4)
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('lot-'.$lot->numero_lot.'.pdf');
    }
}
