<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use DB;

// Controller que centraliza os indicadores exibidos no dashboard.
class DashboardController extends Controller
{
    // Monta as metricas, rankings e listas para a pagina inicial autenticada.
    public function index()
    {
        $totalLivros = Livro::count();
        $totalAutores = Autor::count();
        $totalEditoras = Editora::count();
        $valorLivros = Livro::sum('preco');
        $ultimosLivros = Livro::with('autores')->latest()->take(5)->get();
        $livrosPorEditora = Editora::withCount('livros')->get();
        $topAutores = Autor::withCount('livros')
            ->orderBy('livros_count', 'desc')
            ->take(5)
            ->get();
        $livroMaisCaro = Livro::orderBy('preco', 'desc')->first();
        $livroMaisBarato = Livro::orderBy('preco', 'asc')->first();
        return view('dashboard', compact(
            'totalLivros',
            'totalAutores',
            'totalEditoras',
            'valorLivros',
            'ultimosLivros',
            'livrosPorEditora',
            'topAutores',
            'livroMaisCaro',
            'livroMaisBarato'
        ));
    }
}