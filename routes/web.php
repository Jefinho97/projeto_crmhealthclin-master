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
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\MaterialController;

/** Rotas Orçamento */

Route::get('/', [OrcamentoController::class, 'index']);

Route::middleware('auth')->group(function() {

    Route::prefix('orcamentos')->name('orcamentos.')->group( function() {

        Route::get('dashboard', [OrcamentoController::class, 'dashboard'])->name('dashboard');
        Route::get('create', [OrcamentoController::class, 'create'])->name('create');
        Route::post('', [OrcamentoController::class, 'store'])->name('store');
        Route::get('{id}', [OrcamentoController::class, 'show'])->name('show');
        Route::get('{id}/pdf', [OrcamentoController::class, 'gerarpdf'])->name('gerarpdf');
        Route::delete('{id}', [OrcamentoController::class, 'destroy'])->name('destroy');
        Route::get('edit/{id}', [OrcamentoController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [OrcamentoController::class, 'update'])->name('update');
        Route::put('status/{id}', [OrcamentoController::class, 'status'])->name('status');
        Route::put('razao_status/{id}', [OrcamentoController::class, 'razao_status'])->name('razao_status');
        Route::put('up_show/{id}', [OrcamentoController::class, 'up_show'])->name('up_show');

    });

    /** Rotas Diarias */

    Route::prefix('diarias')->name('diarias.')->group( function(){

        Route::get('create', [DiariaController::class, 'create'])->name('create');
        Route::post('', [DiariaController::class, 'store'])->name('store');
        Route::delete('{id}', [DiariaController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [DiariaController::class, 'dashboard'])->name('dashboard');
        Route::get('edit/{id}', [DiariaController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [DiariaController::class, 'update'])->name('update');

    });

    /** Rotas Equipes */

    Route::prefix('equipes')->name('equipes.')->group( function(){

        Route::get('create', [EquipeController::class, 'create'])->name('create');
        Route::post('', [EquipeController::class, 'store'])->name('store');
        Route::delete('{id}', [EquipeController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [EquipeController::class, 'dashboard'])->name('dashboard');
        Route::get('edit/{id}', [EquipeController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [EquipeController::class, 'update'])->name('update');

    });

    /** Rotas Materiais */

    Route::prefix('materiais')->name('materiais.')->group( function(){

        Route::get('create', [MaterialController::class, 'create'])->name('create');
        Route::post('', [MaterialController::class, 'store'])->name('store');
        Route::delete('{id}', [MaterialController::class, 'destroy'])->name('destroy');
        Route::get('dashboard', [MaterialController::class, 'dashboard'])->name('dashboard');
        Route::get('edit/{id}', [MaterialController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [MaterialController::class, 'update'])->name('update');

    });

});


