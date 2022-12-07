<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVentaModel extends Model
{
    use HasFactory;

    protected $table = 'detalleventas';

    protected $fillable = [
        'id',
        'cantidad',
        'venta_id',
        'producto_id',
    ];

    public function ventas(){
        return $this->belongsTo('App\Models\VentaModel', 'venta_id');
    }

    public function productos(){
        return $this->belongsTo('App\Models\ProductoModel', 'producto_id');
    }
}
