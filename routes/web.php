<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\DiariaController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicoController;

/** Rotas Orçamento */

Route::get('/', [OrcamentoController::class, 'index']);

Route::middleware('auth')->group(function() {

    Route::prefix('orcamentos')->name('orcamentos.')->group( function() {

        Route::get('dashboard', [OrcamentoController::class, 'dashboard'])->name('dashboard');
        Route::post('', [OrcamentoController::class, 'store'])->name('store');
        Route::get('{id}', [OrcamentoController::class, 'show'])->name('show');
        Route::get('{id}/pdf', [OrcamentoController::class, 'gerarpdf'])->name('gerarpdf');
        Route::delete('{id}', [OrcamentoController::class, 'destroy'])->name('destroy');
        Route::get('edit/{id}', [OrcamentoController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [OrcamentoController::class, 'update'])->name('update');
        Route::put('status/{id}', [OrcamentoController::class, 'status'])->name('status');
        Route::put('razao_status/{id}', [OrcamentoController::class, 'razao_status'])->name('razao_status');
        Route::get('show/{id}', [OrcamentoController::class, 'show'])->name('show');
        Route::put('up_show/{id}',[OrcamentoController::class, 'up_show'])->name('up_show');

    });

    /** Rotas Diarias */

    Route::prefix('diarias')->name('diarias.')->group( function(){
        Route::get('dashboard', [DiariaController::class, 'dashboard'])->name('dashboard');
        Route::post('', [DiariaController::class, 'store'])->name('store');
        Route::get('{id}', [DiariaController::class, 'edit'])->name('edit');
        Route::delete('{id}', [DiariaController::class, 'destroy'])->name('destroy');
    });

    /** Rotas Equipes */

    Route::prefix('equipes')->name('equipes.')->group( function(){

        Route::get('dashboard', [EquipeController::class, 'dashboard'])->name('dashboard');
        Route::post('', [EquipeController::class, 'store'])->name('store');
        Route::delete('{id}', [EquipeController::class, 'destroy'])->name('destroy');
        Route::get('{id}', [EquipeController::class, 'edit'])->name('edit');

    });

    /** Rotas Materiais */

    Route::prefix('materiais')->name('materiais.')->group( function(){

        Route::post('', [MaterialController::class, 'store'])->name('store');
        Route::delete('{id}', [MaterialController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [MaterialController::class, 'dashboard'])->name('dashboard');
        Route::get('{id}', [MaterialController::class, 'edit'])->name('edit');
        
    });

    /** Rotas Dietas */

    Route::prefix('dietas')->name('dietas.')->group( function(){

        Route::post('', [DietaController::class, 'store'])->name('store');
        Route::delete('{id}', [DietaController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [DietaController::class, 'dashboard'])->name('dashboard');
        Route::get('{id}', [DietaController::class, 'edit'])->name('edit');
        
    });

    /** Rotas Equipamentos */

    Route::prefix('equipamentos')->name('equipamentos.')->group( function(){

        Route::post('', [EquipamentoController::class, 'store'])->name('store');
        Route::delete('{id}', [EquipamentoController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [EquipamentoController::class, 'dashboard'])->name('dashboard');
        Route::get('{id}', [EquipamentoController::class, 'edit'])->name('edit');
        
    });

    /** Rotas Medicamentos */

    Route::prefix('medicamentos')->name('medicamentos.')->group( function(){

        Route::post('', [MedicamentoController::class, 'store'])->name('store');
        Route::delete('{id}', [MedicamentoController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [MedicamentoController::class, 'dashboard'])->name('dashboard');
        Route::get('{id}', [MedicamentoController::class, 'edit'])->name('edit');
        
    });

    /** Rotas Medicos */

    Route::prefix('medicos')->name('medicos.')->group( function(){

        Route::post('', [MedicoController::class, 'store'])->name('store');
        Route::delete('{id}', [MedicoController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [MedicoController::class, 'dashboard'])->name('dashboard');
        Route::get('{id}', [MedicoController::class, 'edit'])->name('edit');
        
    });
});


