<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $fillable = [
        'nome',
        'foto',
        'bibliografia'
    ];

    // Relacao N:N entre autores e livros.
    public function livros()
    {
        return $this->belongsToMany(Livro::class);
    }
}

