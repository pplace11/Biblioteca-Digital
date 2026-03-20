<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    // Mostra a área de gestão com número total e lista de administradores.
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->latest()
            ->get();

        $totalAdmins = $admins->count();

        return view('admin.users.index', compact('admins', 'totalAdmins'));
    }

    // Mostra o formulario para criar um novo utilizador admin.
    public function create()
    {
        return view('admin.users.create');
    }

    // Cria um novo utilizador com papel de admin.
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => Str::before($data['email'], '@'),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admins.index')->with('success', 'Novo admin criado com sucesso.');
    }

    // Remove um administrador, impedindo a remoção da própria conta autenticada.
    public function destroy(User $admin)
    {
        if ($admin->role !== 'admin') {
            return redirect()->route('admins.index')->with('error', 'O utilizador selecionado não é um admin.');
        }

        if (Auth::id() === $admin->id) {
            return redirect()->route('admins.index')->with('error', 'Não pode apagar a sua própria conta de admin.');
        }

        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin apagado com sucesso.');
    }
}



