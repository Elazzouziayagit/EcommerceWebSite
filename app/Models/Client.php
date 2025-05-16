<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_client';
    protected $table = 'clients';

    protected $fillable = [
        'nom', 'email', 'password', 'adresse', 'telephone', 'date_inscription'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_client');
    }

    public function panier()
    {
        return $this->hasMany(Panier::class, 'id_client');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'id_client');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_client');
    }
}
