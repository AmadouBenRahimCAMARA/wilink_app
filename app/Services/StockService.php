<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\MouvementStock;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class StockService
{
    /**
     * Transfère un nombre de tickets d'un type donné du stock Admin vers un Revendeur.
     *
     * @param int $typeTicketId
     * @param int $quantite
     * @param User $adminSource
     * @param User $revendeurDest
     * @return int Nombre de tickets transférés
     * @throws Exception
     */
    public function attribuerMasse(int $typeTicketId, int $quantite, User $adminSource, User $revendeurDest)
    {
        return DB::transaction(function () use ($typeTicketId, $quantite, $adminSource, $revendeurDest) {
            
            // 1. Sélectionner les tickets disponibles en Stock Central (revendeur_actuel_id = NULL)
            // et qui sont au statut 'cree' ou 'retour_stock'
            $tickets = Ticket::where('type_ticket_id', $typeTicketId)
                             ->whereNull('revendeur_actuel_id')
                             ->whereIn('statut', ['cree']) // On pourrait ajouter d'autres statuts si gestion retour
                             ->limit($quantite)
                             ->lockForUpdate() // Verrouiller pour éviter concurrence
                             ->get();

            if ($tickets->count() < $quantite) {
                throw new Exception("Stock insuffisant. Seulement " . $tickets->count() . " tickets disponibles.");
            }

            $now = Carbon::now();
            $mouvementsData = [];
            $ticketIds = $tickets->pluck('id')->toArray();

            // 2. Mettre à jour les tickets
            Ticket::whereIn('id', $ticketIds)->update([
                'revendeur_actuel_id' => $revendeurDest->id,
                'statut' => 'en_stock_revendeur',
                'date_attribution_revendeur' => $now,
                'updated_at' => $now,
            ]);

            // 3. Créer les mouvements de stock
            foreach ($ticketIds as $tId) {
                $mouvementsData[] = [
                    'ticket_id' => $tId,
                    'source_user_id' => $adminSource->id, // Admin qui donne
                    'destination_user_id' => $revendeurDest->id,
                    'type_mouvement' => 'attribution_revendeur',
                    'date_mouvement' => $now,
                    'cree_par' => $adminSource->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            
            MouvementStock::insert($mouvementsData);

            // 4. (Optionnel) Mise à jour solde dette si pré-paiement ou post-paiement géré ici
            
            return $tickets->count();
        });
    }

    /**
     * Retour de stock (Revendeur -> Admin)
     */
    public function retourStock(array $ticketIds, User $revendeurSource, User $adminDest)
    {
        // ... implémentation future si besoin
    }
}
