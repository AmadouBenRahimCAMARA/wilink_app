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
        $adminRole = Role::firstOrCreate(
            ['nom' => 'Administrateur'],
            ['description' => 'Administrateur de la plateforme']
        );
        
        $revendeurRole = Role::firstOrCreate(
            ['nom' => 'Revendeur'],
            ['description' => 'Vendeur de tickets']
        );

        $agentRole = Role::firstOrCreate(
            ['nom' => 'Agent'],
            ['description' => 'Importateur et distributeur de tickets']
        );

        // 2. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@wilink.com'],
            [
                'nom' => 'System',
                'prenom' => 'Admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'telephone' => '+226123456789',
                'actif' => true,
            ]
        );

        $agent = User::firstOrCreate(
            ['email' => 'agent@wilink.com'],
            [
                'nom' => 'Support',
                'prenom' => 'Agent',
                'password' => Hash::make('password'),
                'role_id' => $agentRole->id,
                'telephone' => '+22600000000',
                'actif' => true,
            ]
        );

        $revendeurUser = User::firstOrCreate(
            ['email' => 'vendeur@wilink.com'],
            [
                'nom' => 'Test',
                'prenom' => 'Revendeur',
                'password' => Hash::make('password'),
                'role_id' => $revendeurRole->id,
                'telephone' => '+22601020304',
                'actif' => true,
            ]
        );

        // 3. Revendeur Profil
        Revendeur::firstOrCreate(
            ['utilisateur_id' => $revendeurUser->id],
            [
                'solde_actuel' => 0,
            ]
        );

        // 4. Zone & Routeur
        $zone = ZoneWifi::firstOrCreate(['nom' => 'Zone Principale']);
        
        Routeur::firstOrCreate(
            ['adresse_ip' => '192.168.88.1'],
            [
                'nom' => 'MikroTik Core',
                'zone_id' => $zone->id,
                'type' => 'MikroTik'
            ]
        );

        // 5. Types Tickets
        TypeTicket::firstOrCreate(
            ['nom' => '1 Heure'],
            [
                'prix_public' => 100.00,
                'prix_revendeur_defaut' => 80.00,
                'duree_minutes' => 60,
                'profil_hotspot' => '1h_profile'
            ]
        );

        TypeTicket::firstOrCreate(
            ['nom' => '24 Heures'],
            [
                'prix_public' => 500.00,
                'prix_revendeur_defaut' => 400.00,
                'duree_minutes' => 1440,
                'profil_hotspot' => '24h_profile'
            ]
        );
    }
}
