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
        $materiais = [
            ['nome' => 'ÁGUA DESTILADA 1000ML', 'uni_medida' => 'ML', 'custo' => 7.50, 'venda' => 22.50, 'user_id' => 1],
            ['nome' => 'Abaixador de lingua pct c/100', 'uni_medida' => 'Pacote', 'custo' => 18.00, 'venda' => 54.00, 'user_id' => 1],
            ['nome' => 'Acidos graxos essenciais 200 ml', 'uni_medida' => 'Frasco', 'custo' => 0.03, 'venda' => 0.09, 'user_id' => 1],
            ['nome' => 'Água destilada flaconete 10ml', 'uni_medida' => 'unidade', 'custo' => 0.39, 'venda' => 1.17, 'user_id' => 1],
        ];
        Material::insert($materiais);
    }
}
