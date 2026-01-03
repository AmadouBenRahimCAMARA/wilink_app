<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Revendeur;

class RevendeurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Récupérer les utilisateurs avec le rôle 2 (Revendeur) et leur profil associé
        $revendeurs = User::where('role_id', 2)
                          ->with('revendeur')
                          ->latest()
                          ->paginate(10);
        
        return view('admin.revendeurs.index', compact('revendeurs'));
    }
}
