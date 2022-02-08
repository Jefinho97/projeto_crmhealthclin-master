<?php

namespace Database\Seeders;

use App\Models\Dieta;
use Illuminate\Database\Seeder;

class DietasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dietas = [
            ['nome' => 'Isosource 1.5', 'uni_medida' => 'Litros', 'custo' => 38.00, 'venda' => 114.00, 'user_id' => 1],
            ['nome' => 'Isosource soya fiber', 'Litros' => 'Pacote', 'custo' => 38.00, 'venda' => 114.00, 'user_id' => 1],
            ['nome' => 'Novasource gc 1.5 sistema fechado - 1.000 ml', 'Litros' => 'Frasco', 'custo' => 38.00, 'venda' => 114.00, 'user_id' => 1],
            ['nome' => 'Nutrison multi fiber - 800 g', 'uni_medida' => 'frasco', 'custo' => 38.00, 'venda' => 114.00, 'user_id' => 1],
        ];
        Dieta::insert($dietas);
    }
}
