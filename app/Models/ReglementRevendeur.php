<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglementRevendeur extends Model
{
    use HasFactory;

    protected $table = 'reglements_revendeur';

    protected $fillable = [
        'revendeur_id',
        'montant',
        'mode_paiement',
        'reference_preuve',
        'recu_par'
    ];

    public function revendeur()
    {
        return $this->belongsTo(User::class, 'revendeur_id');
    }

    public function admin_receveur()
    {
        return $this->belongsTo(User::class, 'recu_par');
    }
}
