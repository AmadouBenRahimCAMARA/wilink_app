<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Revendeur;
use App\Models\TypeTicket;
use App\Models\ZoneWifi;
use App\Models\Routeur;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Roles
        $adminRole = Role::create(['nom' => 'Administrateur', 'description' => 'Super Admin']);
        $revendeurRole = Role::create(['nom' => 'Revendeur', 'description' => 'Vendeur de tickets']);

        // 2. Users is
        $admin = User::create([
            'name' => 'Admin System',
            'email' => 'admin@wilink.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'actif' => true,
        ]);

        $revendeurUser = User::create([
            'name' => 'Revendeur Test',
            'email' => 'vendeur@wilink.com',
            'password' => Hash::make('password'),
            'role_id' => $revendeurRole->id,
            'actif' => true,
        ]);

        // 3. Revendeur Profil
        Revendeur::create([
            'utilisateur_id' => $revendeurUser->id,
            'telephone' => '0102030405',
            'solde_actuel' => 0,
        ]);

        // 4. Zone & Routeur
        $zone = ZoneWifi::create(['nom' => 'Zone Principale']);
        Routeur::create([
            'nom' => 'MikroTik Core',
            'adresse_ip' => '192.168.88.1',
            'zone_id' => $zone->id,
            'type' => 'MikroTik'
        ]);

        // 5. Types Tickets
        TypeTicket::create([
            'nom' => '1 Heure',
            'prix_public' => 100.00,
            'prix_revendeur_defaut' => 80.00,
            'duree_minutes' => 60,
            'profil_hotspot' => '1h_profile'
        ]);

        TypeTicket::create([
            'nom' => '24 Heures',
            'prix_public' => 500.00,
            'prix_revendeur_defaut' => 400.00,
            'duree_minutes' => 1440,
            'profil_hotspot' => '24h_profile'
        ]);
    }
}
