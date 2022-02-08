<?php

namespace Database\Seeders;

use App\Models\Equipamento;
use Illuminate\Database\Seeder;

class EquipamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipamentos = [
            ['nome' => 'Concentrador de O²', 'marca_modelo' => 'Philips Respironics/ Inspirar','uni_medida' => '15 dias (alguel) ', 'preco' => 175.00, 'depreciacao' => 36.00, 'custo_dia' => 0.32, 'valor_dia' => 0.57, 'user_id' => 1],
            ['nome' => 'Nobreak incluso com o respirador', 'marca_modelo' => 'SMS/ inspirar','uni_medida' => '30 dias (alguel)', 'preco' => 145.00, 'depreciacao' => 1.0, 'custo_dia' => 4.75, 'valor_dia' => 8.56, 'user_id' => 1],
            ['nome' => 'Respirador Mecânico BIPAP', 'marca_modelo' => 'Philips Respironics/ Inspirar','uni_medida' => '30 dias (alguel)', 'preco' => 1410.00, 'depreciacao' => 24.00, 'custo_dia' => 1.93, 'valor_dia' => 3.47, 'user_id' => 1],
            ['nome' => 'Respirador Mecânico Trilogy', 'marca_modelo' => 'Philips Respironics/ Inspirar','uni_medida' => '30 dias (alguel)', 'preco' => 3000.00, 'depreciacao' => 24.00, 'custo_dia' => 4.10, 'valor_dia' => 7.38, 'user_id' => 1],
        ];
        Equipamento::insert($equipamentos);
    }
}
