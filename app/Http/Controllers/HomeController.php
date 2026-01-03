<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) { // 1 = Admin (Selon seeder)
            return redirect()->route('admin.tickets.index');
        } elseif ($user->role_id == 2) { // 2 = Revendeur
            return redirect()->route('reseller.dashboard'); 
        }

        return view('home');
    }
}
