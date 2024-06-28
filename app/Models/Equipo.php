<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    public $table = 'equipo';
    public $fillable = ['nombre_equipo', 'nombre_dt', 'logo']; // $guarded = []
    protected $timestamps = false;
}
