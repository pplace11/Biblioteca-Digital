<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $fillable = [
        'isbn',
        'nome',
        'editora_id',
        'bibliografia',
        'imagem_capa',
        'preco'
    ];

    // Relacao N:1 com a editora do livro.
    public function editora()
    {
        return $this->belongsTo(Editora::class);
    }

    // Relacao N:N com os autores do livro.
    public function autores()
    {
        return $this->belongsToMany(Autor::class);
    }
}
