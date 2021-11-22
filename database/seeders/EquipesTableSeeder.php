<?php

namespace Database\Seeders;

use App\Models\Equipe;
use Illuminate\Database\Seeder;

class EquipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipes = [
            ['funcao' => 'Tecnico em enfermagem', 'custo' => 1750.00, 'venda' => 2000.00, 'user_id' => 1],
            ['funcao' => 'Cuidador', 'custo' => 2250.00, 'venda' => 2500.00, 'user_id' => 1],
        ];
        Equipe::insert($equipes);
    }
}
