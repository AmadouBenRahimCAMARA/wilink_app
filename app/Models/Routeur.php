<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routeur extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'adresse_ip', 'api_user', 'api_password', 'zone_id', 'type'];
}
