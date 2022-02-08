<?php

namespace Database\Seeders;

use App\Models\Medicamento;
use Illuminate\Database\Seeder;

class MedicamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicamentos = [
            ['nome' => 'AAS 100 mg ', 'uni_medida' => 'Comprimido', 'custo' => 0.27, 'venda' => 0.81, 'user_id' => 1],
            ['nome' => 'Acetilcisteína 600 mg - sachê', 'uni_medida' => 'Unidades', 'custo' => 2.86, 'venda' => 54.00, 'user_id' => 1],
            ['nome' => 'Amiodarona 200mg', 'uni_medida' => 'Comprimido', 'custo' => 1.25, 'venda' => 3.75, 'user_id' => 1],
            ['nome' => 'Brometo de ipratrópio 25mg/ml', 'uni_medida' => 'Frasco (GOTAS)', 'custo' => 0.01, 'venda' => 0.03, 'user_id' => 1],
        ];
        Medicamento::insert($medicamentos);
    }
}
