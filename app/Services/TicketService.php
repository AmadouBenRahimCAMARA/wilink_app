<?php

namespace App\Services;

use App\Models\Ticktet; // Typo fix later if needed, but standard is Ticket
use App\Models\Ticket;
use App\Models\LotTicket;
use App\Models\TypeTicket;
use App\Models\MouvementStock;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketService
{
    /**
     * Génère un lot de tickets unique.
     *
     * @param TypeTicket $type
     * @param int $quantite
     * @param User $adminCreateur
     * @return LotTicket
     */
    public function genererLot(TypeTicket $type, int $quantite, User $adminCreateur)
    {
        return DB::transaction(function () use ($type, $quantite, $adminCreateur) {
            
            // 1. Créer le Lot
            $numeroLot = 'LOT-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(5));
            
            $lot = LotTicket::create([
                'numero_lot' => $numeroLot,
                'type_ticket_id' => $type->id,
                'quantite' => $quantite,
                'cree_par' => $adminCreateur->id,
            ]);

            // 2. Générer les tickets
            $ticketsData = [];
            $now = Carbon::now();
            
            for ($i = 0; $i < $quantite; $i++) {
                $code = $this->genererCodeUnique();
                
                $ticketsData[] = [
                    'code' => $code,
                    'type_ticket_id' => $type->id,
                    'lot_ticket_id' => $lot->id,
                    'revendeur_actuel_id' => null, // Stock Admin (Central)
                    'statut' => 'cree',
                    'checksum' => hash('sha256', $code . $lot->id), // Securité simple
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Insertion de masse pour performance
            Ticket::insert($ticketsData);

            // 3. Synchronisation RADIUS (radcheck & radusergroup)
            // On prépare les données pour l'insertion de masse
            $radcheckData = [];
            $radgroupData = [];
            
            // On récupère le nom du profil RADIUS associé au type de ticket (ex: '1h-profile')
            $groupName = $type->profil_hotspot ?? 'default'; 
            // Si le champ profil_hotspot est vide, on met 'default' ou on lève une exception selon la rigueur voulue

            foreach ($ticketsData as $tData) {
                // Login = Code, Password = Code (Authentification simple par code)
                $radcheckData[] = [
                    'username' => $tData['code'],
                    'attribute' => 'Cleartext-Password',
                    'op' => ':=',
                    'value' => $tData['code'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Associer au groupe (Profil de limitation temps/débit)
                $radgroupData[] = [
                    'username' => $tData['code'],
                    'groupname' => $groupName,
                    'priority' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Insertion dans les tables RADIUS
            DB::table('radcheck')->insert($radcheckData);
            DB::table('radusergroup')->insert($radgroupData);

            // 3. Enregistrer le mouvement de stock (Entrée Stock Central)
            // On ne crée pas 100 lignes de mouvements pour la création initiale pour ne pas spammer,
            // ou alors on fait un mouvement global "Génération".
            // Pour ce systême, on va dire que la création du Ticket EST l'entrée en stock.
            // Mais pour la traçabilité stricte, on pourrait ajouter un log.
            
            return $lot;
        });
    }

    /**
     * Génère un code numérique unique de 10 chiffres (lisible).
     * Format : 1234-5678-90
     */
    private function genererCodeUnique()
    {
        do {
            // Génère 10 chiffres aléatoires
            $number = mt_rand(1000000000, 9999999999);
            // Formatage éventuel (ex: pas de formatage en base, formatage à l'affichage)
            $code = (string)$number;
            
            // Vérif unicité
        } while (Ticket::where('code', $code)->exists());

        return $code;
    }
}
