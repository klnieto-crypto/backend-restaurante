<?php
// karen: [Modelo Reserva]
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';
    
    protected $fillable = [
        'mesa_id',
        'cliente_nombre',
        'cliente_telefono',
        'fecha',
        'hora',
        'num_personas',
        'estado'
    ];
}