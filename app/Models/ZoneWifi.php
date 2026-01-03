<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneWifi extends Model
{
    use HasFactory;
    protected $table = 'zones_wifi';
    protected $fillable = ['nom', 'description'];
}
