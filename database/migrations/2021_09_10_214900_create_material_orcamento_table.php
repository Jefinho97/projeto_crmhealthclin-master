<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialOrcamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_orcamento', function (Blueprint $table) {
            $table->foreignId('material_id')->constrained();
            $table->foreignId('orcamento_id')->constrained();
            $table->integer('quant')->default(1);
            $table->double('soma_custo', 20, 2)->default(0.00);
            $table->double('soma_venda', 20, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_orcamento');
    }
}
