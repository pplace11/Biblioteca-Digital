<?php

namespace App\Exports;

use App\Models\Livro;
use Maatwebsite\Excel\Concerns\FromCollection;

// Define a colecao de dados utilizada na exportacao de livros.
class LivrosExport implements FromCollection
{
    // Retorna todos os livros para gerar o ficheiro Excel.
    public function collection()
    {
        return Livro::all();
    }
}