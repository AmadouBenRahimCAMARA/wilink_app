<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'indicatif' => ['required', 'string', 'max:5'],
            'telephone' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:8', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $fullPhone = $data['indicatif'] . $data['telephone'];

        $user = User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'telephone' => $fullPhone, // E.g. +22670123456
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => 2, // Force Revendeur Role
        ]);

        // Création automatique du profil Revendeur
        \App\Models\Revendeur::create([
            'utilisateur_id' => $user->id,
            'solde_actuel' => 0,
            'taux_commission_defaut' => 5.00, // 5% par défaut
            'adresse' => 'A compléter',
            'telephone' => 'A compléter',
        ]);

        return $user;
    }
}
