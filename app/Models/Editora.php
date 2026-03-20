<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo que representa uma editora com os seus livros publicados.
class Editora extends Model
{
    protected $fillable = [
        'nome',
        'logotipo'
    ];

    // Relacao 1:N entre editora e livros publicados.
    public function livros()
    {
        return $this->hasMany(Livro::class);
    }
}




