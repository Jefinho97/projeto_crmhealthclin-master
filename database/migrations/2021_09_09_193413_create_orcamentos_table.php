<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('procedimento');
            $table->string('paciente');
            $table->string('email_pac');
            $table->string('telefone_1');
            $table->string('telefone_2');
            $table->string('status')->nullable();
            $table->string('razao_status',200)->nullable();
            $table->boolean('tipo')->default(false);
            $table->text('termos_condicoes')->default('Não Expecificado');
            $table->text('convenios')->default('Não Expecificado');
            $table->text('condicoes_pag')->default('Não Expecificado');
            $table->text('solicitante')->default('Não Informado');
            $table->dateTime('data')->nullable();
            $table->string('medico')->nullable();
            
            $table->double('preco_medico', 20, 2)->default(0.00);
            $table->double('custo_equipe', 20, 2)->default(0.00);
            $table->double('venda_equipe', 20, 2)->default(0.00);
            
            $table->double('custo_diaria', 20, 2)->default(0.00);
            $table->double('venda_diaria', 20, 2)->default(0.00);

            $table->double('custo_material', 20, 2)->default(0.00);
            $table->double('venda_material', 20, 2)->default(0.00);
                       
            $table->double('custo_medicamento', 20, 2)->default(0.00);
            $table->double('venda_medicamento', 20, 2)->default(0.00);

            $table->double('custo_dieta', 20, 2)->default(0.00);
            $table->double('venda_dieta', 20, 2)->default(0.00);
            
            $table->double('custo_equipamento', 20, 2)->default(0.00);
            $table->double('venda_equipamento', 20, 2)->default(0.00);

            $table->double('desconto', 20, 2)->default(0.00);
            $table->double('valor_inicial', 20, 2)->default(0.00);
            $table->double('valor_final', 20, 2)->default(0.00);
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('orcamentos');
    }
}
