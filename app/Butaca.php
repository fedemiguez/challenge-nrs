<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Butaca extends Model
{
    protected $fillable = ['fila', 'columna', 'reserva_id'];

    public function reserva(){
        return $this->belongsTo('App\Reserva');
    }
}
