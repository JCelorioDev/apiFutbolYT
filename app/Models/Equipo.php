<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    public $table = 'equipo';
    protected $fillable = ['nombre_equipo', 'nombre_dt', 'logo']; // $guarded = []
    public $timestamps = false;
}
