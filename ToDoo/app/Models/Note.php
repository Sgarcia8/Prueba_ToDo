<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'etiquetas',
        'img_uri',
        'fecha_vencimiento',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
