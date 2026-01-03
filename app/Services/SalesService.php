<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Vente;
use App\Models\LigneVente;
use App\Models\User;
use App\Models\TypeTicket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;

class SalesService
{
    /**
     * Effectue une vente unitaire d'un ticket par un revendeur.
     *
     * @param User $vendeur
     * @param int $typeTicketId
     * @return Ticket
     * @throws Exception
     */
    public function vendreUnitaire(User $vendeur, int $typeTicketId)
    {
        return DB::transaction(function () use ($vendeur, $typeTicketId) {
            
            // 1. Trouver un ticket disponible dans le stock du revendeur
            $ticket = Ticket::where('type_ticket_id', $typeTicketId)
                            ->where('revendeur_actuel_id', $vendeur->id)
                            ->where('statut', 'en_stock_revendeur')
                            ->lockForUpdate() // Eviter double vente
                            ->first();

            if (!$ticket) {
                throw new Exception("Stock épuisé pour ce type de ticket.");
            }

            $now = Carbon::now();
            $type = $ticket->type_ticket; // Eager load si possible ou lazy loading

            // 2. Créer l'enregistrement de Vente
            $vente = Vente::create([
                'reference' => 'V-' . strtoupper(Str::random(8)),
                'revendeur_id' => $vendeur->id,
                'montant_total' => $type->prix_public, // Prix vendu au client
                'montant_commission' => $type->prix_public - $type->prix_revendeur_defaut, // Gain théorique
                'statut' => 'payee', // Considéré payé par le client final
                'date_vente' => $now,
            ]);

            // 3. Créer la ligne de vente
            LigneVente::create([
                'vente_id' => $vente->id,
                'ticket_id' => $ticket->id,
                'prix_unitaire_applique' => $type->prix_public,
            ]);

            // 4. Mettre à jour le ticket
            $ticket->update([
                'statut' => 'vendu',
                'date_vente' => $now,
                'vente_id' => $vente->id
            ]);

            // 5. Mettre à jour la dette/solde du revendeur
            // Si le business model est "Le revendeur doit l'argent du prix_revendeur à l'admin"
            // Alors on augmente sa dette de prix_revendeur_defaut
            $revendeurProfile = $vendeur->revendeur;
            if ($revendeurProfile) {
                // On ajoute le prix revendeur à la dette (solde négatif = dette par exemple, ou positif = dette, à définir)
                // Ici on va dire : Solde = Ce que le revendeur a en caisse qui appartient à l'Admin
                $revendeurProfile->increment('solde_actuel', $type->prix_revendeur_defaut);
            }

            return $ticket;
        });
    }
}
