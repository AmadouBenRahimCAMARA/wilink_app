<?php

namespace App\Imports;

use App\Models\Ticket;
use App\Models\LotTicket;
use App\Models\TypeTicket;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TicketsImport implements ToModel, WithHeadingRow
{
    protected $lotId;
    protected $typeTicketId;
    protected $revendeurId;

    public function __construct($lotId, $typeTicketId, $revendeurId)
    {
        $this->lotId = $lotId;
        $this->typeTicketId = $typeTicketId;
        $this->revendeurId = $revendeurId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Supposons que le fichier a une colonne 'code'
        if (!isset($row['code'])) {
            return null;
        }

        $code = (string)$row['code'];

        // Insertion Sync RADIUS (Critique)
        // Note: Idéalement ceci devrait être dans un Service, mais pour l'import on le fait ici ou via un Observer.
        // Pour la performance, insérer ligne par ligne via Import peut être lent.
        // Mais gardons ça simple.
        
        $now = Carbon::now();
        
        // 1. Radius Check
        DB::table('radcheck')->insertOrIgnore([
            'username' => $code,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $code,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Radius Group (Type Ticket Profile)
        $type = TypeTicket::find($this->typeTicketId);
        $groupName = $type->profil_hotspot ?? 'default';

        DB::table('radusergroup')->insertOrIgnore([
            'username' => $code,
            'groupname' => $groupName,
            'priority' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return new Ticket([
            'code' => $code,
            'type_ticket_id' => $this->typeTicketId,
            'lot_ticket_id' => $this->lotId,
            'revendeur_actuel_id' => $this->revendeurId, // Attribué directement au revendeur
            'statut' => 'cree',
            'checksum' => hash('sha256', $code . $this->lotId),
        ]);
    }
}
