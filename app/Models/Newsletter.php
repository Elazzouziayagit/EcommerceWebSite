<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    // Indique que les champs 'email' peuvent être assignés en masse
    protected $fillable = ['email'];

    // La table est automatiquement 'newsletters' si tu respectes la convention Laravel,
    // sinon, décommente et adapte la ligne suivante :
    // protected $table = 'newsletters';

    // Les timestamps sont activés par défaut, tu peux les garder
}
