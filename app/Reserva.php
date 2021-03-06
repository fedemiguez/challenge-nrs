<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'nombre', 'apellido', 'fecha_reserva', 'cantidad'
    ];

    public function butacas(){
        return $this->hasMany('App\Butaca');
    }
}
