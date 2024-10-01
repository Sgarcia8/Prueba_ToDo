<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Se establece relación de pertenecia unica con la clase usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
