<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo que representa um autor e os seus livros publicados na biblioteca.
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




