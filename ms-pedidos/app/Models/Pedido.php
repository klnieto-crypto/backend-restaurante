<?php
// karen: [Modelo Pedido]
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    
    protected $fillable = [
        'mesa_id',
        'usuario_id',
        'estado',
        'total',
        'fecha',
        'hora'
    ];
}