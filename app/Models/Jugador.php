<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;
    public $table = 'jugador';
    public $fillable = ['nombre_jugador', 'n_camisa', 'posicion_jugador' , 'equipo_id'];
    protected $timestamps = false;
}
