<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTicket extends Model
{
    use HasFactory;

    protected $table = 'types_tickets';

    protected $fillable = [
        'nom',
        'prix_public',
        'prix_revendeur_defaut',
        'duree_minutes',
        'limite_data_mo',
        'profil_hotspot',
        'actif',
    ];
}
