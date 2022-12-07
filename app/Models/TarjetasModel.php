<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarjetasModel extends Model
{
    use HasFactory;

    protected $table = 'tarjetas';

    protected $fillable = [
        'id',
        'card_number',
        'card_cvv',
        'card_expiration',
        'card_type',
        'user_id',
    ];

    public function usuarios(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
