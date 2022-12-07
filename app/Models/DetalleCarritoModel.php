<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCarritoModel extends Model
{
    use HasFactory;

    protected $table = 'detallecarrito';

    protected $fillable = [
        'id_carrito',
        'id_producto',
        'cantidad'
    ];

    public function producto()
    {
        return $this->belongsTo(ProductosModel::class, 'id_producto');
    }
}
