<?php

use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\DashboardController;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $livros = Livro::with('autores')->take(6)->get();
    $totalLivros = Livro::count();
    $totalAutores = Autor::count();
    $totalEditoras = Editora::count();
    return view('welcome', compact(
        'livros',
        'totalLivros',
        'totalAutores',
        'totalEditoras'
    ));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::resource('livros', LivroController::class);
Route::resource('autores', AutorController::class)
    ->parameters(['autores' => 'autor'])
    ->except(['show']);
Route::resource('editoras', EditoraController::class);

Route::get('/autores/{autor}', [AutorController::class,'show'])->name('autores.show');
Route::get('/livros-export', [LivroController::class,'export'])->name('livros.export');
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
