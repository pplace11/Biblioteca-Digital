<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Editora;
use Illuminate\Database\Seeder;

class EditoraSeeder extends Seeder
{
    /**
     * Executa a carga inicial de editoras.
     */
    // Insere editoras padrao com caminho de logotipo.
    public function run()
    {
        Editora::create([
            'nome' => 'Penguin',
            'logotipo' => 'images/editoras/penguin.png'
        ]);
        Editora::create([
            'nome' => 'HarperCollins',
            'logotipo' => 'images/editoras/harpercollins.png'
        ]);
        Editora::create([
            'nome' => 'Companhia das Letras',
            'logotipo' => 'images/editoras/companhia.png'
        ]);
        Editora::create([
            'nome' => 'Rocco',
            'logotipo' => 'images/editoras/rocco.png'
        ]);
        Editora::create([
            'nome' => 'Intrínseca',
            'logotipo' => 'images/editoras/intrinseca.png'
        ]);
        Editora::create([
            'nome' => 'Editora 34',
            'logotipo' => 'images/editoras/34.png'
        ]);
        Editora::create([
            'nome' => 'Saraiva',
            'logotipo' => 'images/editoras/saraiva.png'
        ]);
        Editora::create([
            'nome' => 'Record',
            'logotipo' => 'images/editoras/record.png'
        ]);
    }
}
