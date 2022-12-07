<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoModel extends Model
{
    use HasFactory;

    protected $table = 'carrito';

    protected $fillable = [
        'id_user',
        'total',
        'subtotal',
        'iva'
    ];
}
