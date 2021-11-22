<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            ['tipo' => 'medicamento', 'nome' => 'dipirona', 'uni_medida' => 'mlg', 'custo' => 2250.00, 'venda' => 2500.00, 'user_id' => 1],
            ['tipo' => 'material', 'nome' => 'seringa', 'uni_medida' => 'unidade', 'custo' => 1.00, 'venda' => 1.50, 'user_id' => 1],
            ['tipo' => 'dieta', 'nome' => 'dieta', 'uni_medida' => 'unidade', 'custo' => 1.00, 'venda' => 1.50, 'user_id' => 1],
            ['tipo' => 'equipamento', 'nome' => 'equiipamento', 'uni_medida' => 'unidade', 'custo' => 1.00, 'venda' => 1.50, 'user_id' => 1],
        ];
        Material::insert($materials);
    }
}
