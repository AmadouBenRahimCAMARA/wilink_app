<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revendeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilisateur_id',
        'telephone',
        'adresse',
        'taux_commission_defaut',
        'solde_actuel',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class, 'revendeur_id', 'utilisateur_id');
    }

    public function reglements()
    {
        return $this->hasMany(ReglementRevendeur::class, 'revendeur_id', 'utilisateur_id');
    }
}
