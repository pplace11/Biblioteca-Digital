<?php

namespace App\Http\Controllers;

use App\Exports\LivrosExport;
use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// Controller responsavel pelas operacoes CRUD de livros e exportacao.
class LivroController extends Controller
{
    // Exporta os livros para um ficheiro Excel.
    public function export()
    {
        return Excel::download(new LivrosExport, 'livros.xlsx');
    }

    // Lista livros com filtros de pesquisa e ordenacao dinamica.
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sortBy = $request->input('sort_by', 'nome');
        $sortOrder = $request->input('sort_order', 'asc');

        if (!in_array($sortBy, ['nome', 'editora', 'autor'], true)) {
            $sortBy = 'nome';
        }

        if (!in_array($sortOrder, ['asc', 'desc'], true)) {
            $sortOrder = 'asc';
        }

        $query = Livro::with('autores', 'editora');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhere('bibliografia', 'like', "%{$search}%")
                    ->orWhereHas('autores', function ($autorQuery) use ($search) {
                        $autorQuery->where('nome', 'like', "%{$search}%");
                    })
                    ->orWhereHas('editora', function ($editoraQuery) use ($search) {
                        $editoraQuery->where('nome', 'like', "%{$search}%");
                    });
            });
        }

        // Aplicar ordenação
        if ($sortBy === 'editora') {
            $query->join('editoras', 'livros.editora_id', '=', 'editoras.id')
                ->select('livros.*')
                ->distinct()
                ->orderBy('editoras.nome', $sortOrder);
        } elseif ($sortBy === 'autor') {
            $query->join('autor_livro', 'livros.id', '=', 'autor_livro.livro_id')
                ->join('autors', 'autor_livro.autor_id', '=', 'autors.id')
                ->select('livros.*')
                ->distinct()
                ->orderBy('autors.nome', $sortOrder);
        } else {
            // Ordenar por nome do livro
            $query->orderBy('nome', $sortOrder);
        }

        $livros = $query->get();
        return view('livros.index', compact('livros', 'search', 'sortBy', 'sortOrder'));
    }

    // Exibe o formulario de criacao de livro.
    public function create()
    {
        $autores = Autor::all();
        $editoras = Editora::all();
        return view('livros.create', compact('autores', 'editoras'));
    }

    // Cria um livro e sincroniza os autores selecionados.
    public function store(Request $request)
    {
        $data = $request->validate([
            'isbn' => 'nullable',
            'nome' => 'required',
            'editora_id' => 'required',
            'preco' => 'nullable|numeric',
            'bibliografia' => 'nullable',
            'imagem_capa' => 'nullable|image'
        ]);
        if ($request->hasFile('imagem_capa')) {
            $path = $request->file('imagem_capa')->store('capas', 'public');
            $data['imagem_capa'] = 'storage/' . $path;
        }
        $livro = Livro::create($data);
        $livro->autores()->sync($request->autores);
        return redirect()->route('livros.index');
    }

    // Exibe o formulario de edicao de livro.
    public function edit(Livro $livro)
    {
        $autores = Autor::all();
        $editoras = Editora::all();
        return view('livros.edit', compact('livro', 'autores', 'editoras'));
    }

    // Exibe os detalhes completos do livro.
    public function show(Livro $livro)
    {
        $livro->load('autores', 'editora');

        return view('livros.show', compact('livro'));
    }

    // Atualiza os dados do livro, incluindo capa e autores vinculados.
    public function update(Request $request, Livro $livro)
    {
        $data = $request->validate([
            'isbn' => 'nullable',
            'nome' => 'required',
            'editora_id' => 'required',
            'preco' => 'nullable|numeric',
            'bibliografia' => 'nullable',
            'imagem_capa' => 'nullable|image',
            'autores' => 'nullable|array',
            'autores.*' => 'integer|exists:autors,id'
        ]);

        if ($request->hasFile('imagem_capa')) {
            $path = $request->file('imagem_capa')->store('capas', 'public');
            $data['imagem_capa'] = 'storage/' . $path;
        } else {
            unset($data['imagem_capa']);
        }

        $livro->update($data);
        $livro->autores()->sync($request->autores ?? []);
        return redirect()->route('livros.index');
    }

    // Remove os vinculos de autores e depois exclui o livro.
    public function destroy(Livro $livro)
    {
        $livro->autores()->detach();
        $livro->delete();

        return redirect()->route('livros.index');
    }

}
