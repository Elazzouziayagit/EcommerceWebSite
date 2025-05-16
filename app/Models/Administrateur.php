<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrateur extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_admin';
    protected $table = 'administrateurs';

    protected $fillable = [
        'nom', 'email', 'mot_de_passe', 'role', 'date_creation'
    ];

    protected $hidden = [
        'mot_de_passe', 'remember_token',
    ];

    public function actions()
    {
        return $this->hasMany(ActionAdmin::class, 'id_admin');
    }
}