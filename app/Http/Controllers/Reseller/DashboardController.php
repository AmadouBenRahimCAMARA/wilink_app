<?php

namespace App\Http\Controllers\Reseller;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeTicket;
use App\Models\Ticket;
use App\Services\SalesService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->middleware('auth');
        $this->salesService = $salesService;
    }

    public function index()
    {
        $user = Auth::user();

        // Récupérer le stock du revendeur groupé par type
        $types = TypeTicket::where('actif', true)->get()->map(function($type) use ($user) {
            $type->stock_perso = Ticket::where('type_ticket_id', $type->id)
                                         ->where('revendeur_actuel_id', $user->id)
                                         ->where('statut', 'en_stock_revendeur')
                                         ->count();
            return $type;
        });

        return view('reseller.dashboard', compact('types'));
    }

    public function sell(Request $request)
    {
        $request->validate([
            'type_ticket_id' => 'required|exists:types_tickets,id',
        ]);

        try {
            $ticket = $this->salesService->vendreUnitaire(
                Auth::user(),
                $request->type_ticket_id
            );

            return view('reseller.sale_success', compact('ticket'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
