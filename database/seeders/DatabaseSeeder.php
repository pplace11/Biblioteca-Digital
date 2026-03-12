<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Seeder principal que orquestra a carga de dados iniciais.
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
        * Executa os seeders da aplicacao.
     */
    public function run(): void
    {
        $this->call([
        AutorSeeder::class,
        EditoraSeeder::class,
        LivroSeeder::class
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
