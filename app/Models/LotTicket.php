<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotTicket extends Model
{
    use HasFactory;
    protected $table = 'lots_tickets';
    protected $fillable = ['numero_lot', 'type_ticket_id', 'quantite', 'cree_par'];

    public function type_ticket()
    {
        return $this->belongsTo(TypeTicket::class);
    }

    public function createur()
    {
        return $this->belongsTo(User::class, 'cree_par');
    }
}
