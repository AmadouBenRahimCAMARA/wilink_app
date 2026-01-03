<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type_ticket_id',
        'lot_ticket_id',
        'revendeur_actuel_id',
        'statut',
        'date_attribution_revendeur',
        'date_vente',
        'date_activation',
        'vente_id',
        'checksum',
    ];

    protected $casts = [
        'date_attribution_revendeur' => 'datetime',
        'date_vente' => 'datetime',
        'date_activation' => 'datetime',
    ];

    public function type_ticket()
    {
        return $this->belongsTo(TypeTicket::class);
    }

    public function lot()
    {
        return $this->belongsTo(LotTicket::class, 'lot_ticket_id');
    }

    public function revendeur_actuel()
    {
        return $this->belongsTo(User::class, 'revendeur_actuel_id');
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}
