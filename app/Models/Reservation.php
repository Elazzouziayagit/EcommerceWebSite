<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $primaryKey = 'id_reservation';
    protected $table = 'reservations';

    protected $fillable = [
        'id_client', 'id_parfum', 'date_reservation', 'statut'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function parfum()
    {
        return $this->belongsTo(Parfum::class, 'id_parfum');
    }
}