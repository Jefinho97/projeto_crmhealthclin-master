<?php

namespace Database\Seeders;

use App\Models\Medico;
use Illuminate\Database\Seeder;

class MedicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicos = [
            ['nome' => 'Rodolfo', 'CRM' => 1, 'UF' => 'mg', 'user_id' => 1],
            ['nome' => 'Jeremias', 'CRM' => 2, 'UF' => 'sp', 'user_id' => 1],
            ['nome' => 'Pamela', 'CRM' => 3, 'UF' => 'ac', 'user_id' => 1],
        ];
        Medico::insert($medicos);
    }
}
