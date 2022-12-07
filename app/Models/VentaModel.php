<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaModel extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'id',
        'fecha',
        'subtotal',
        'iva',
        'total',
        'usuario_id',
    ];

    public function usuarios(){
        return $this->belongsTo('App\Models\UsuarioModel', 'usuario_id');
    }
}
