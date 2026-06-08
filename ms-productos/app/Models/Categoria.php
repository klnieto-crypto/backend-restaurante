<?php
// karen: [Modelo Producto]
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    
    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'disponible'
    ];
}