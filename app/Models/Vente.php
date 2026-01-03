<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'revendeur_id',
        'montant_total',
        'montant_commission',
        'statut',
        'date_vente',
    ];

    protected $casts = [
        'date_vente' => 'datetime',
    ];

    public function revendeur()
    {
        return $this->belongsTo(User::class, 'revendeur_id');
    }

    public function lignes()
    {
        return $this->hasMany(LigneVente::class);
    }
}
