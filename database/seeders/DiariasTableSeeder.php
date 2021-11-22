<?php

namespace Database\Seeders;

use App\Models\Diaria;
use Illuminate\Database\Seeder;

class DiariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $diarias = [
            ['descricao' => 'UTI', 'custo' => 2500.00, 'venda' => 3250.00, 'user_id' => 1],
            ['descricao' => 'Apartamento', 'custo' => 1500.00, 'venda' => 2000.00, 'user_id' => 1]
        ];
        Diaria::insert($diarias);
    }
}
