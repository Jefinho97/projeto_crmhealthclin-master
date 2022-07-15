<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(class: AdminUserSeeder::class);
        $this->call(class: DiariasTableSeeder::class);
        $this->call(class: EquipesTableSeeder::class);
        $this->call(class: MaterialsTableSeeder::class);
        $this->call(class: DietasTableSeeder::class);
        $this->call(class: EquipamentosTableSeeder::class);
        $this->call(class: MedicamentosTableSeeder::class);
        $this->call(class: MedicosTableSeeder::class);
    }
}
