<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vente;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Vente::where('revendeur_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reseller.sales.index', compact('sales'));
    }
}
