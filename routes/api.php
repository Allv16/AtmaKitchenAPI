<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\HampersController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenitipController;

//Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/email/resend/{email}', [VerificationController::class, 'resend']);
Route::get('/not-authenticated', [AuthController::class, 'notAuthenticated'])->name('not-authenticated');
Route::post('/send-verification', [AuthController::class, 'sendVerification']);
Route::get('/reset-password/{resetToken}', [AuthController::class, 'resetPassword']);
Route::post('/validate-forgot-password', [AuthController::class, 'validateForgotPassword']);

//Role
Route::get('/roles', [RoleController::class, 'getAllRoles']);


Route::middleware('auth:sanctum')->group(function () {
    //Role
    Route::post('/roles/add', [RoleController::class, 'addRole']);
    Route::put('/roles/edit/{idRole}', [RoleController::class, 'editRole']);
    Route::delete('/roles/delete/{idRole}', [RoleController::class, 'deleteRole']);

    //produk
    Route::get('/products', [ProdukController::class, 'getAllProducts']);
    Route::get('/products/getTopProduct', [ProdukController::class, 'getTopProduct']);
    Route::get('/products/random', [ProdukController::class, 'getRandomProducts']);
    Route::get('/products/own-products', [ProdukController::class, 'getOwnProducts']);
    Route::get('/products/category/cakes', [ProdukController::class, 'getCakesProducts']);
    Route::get('/products/category/roti', [ProdukController::class, 'getRotiProducts']);
    Route::get('/products/category/minuman', [ProdukController::class, 'getMinumanProducts']);
    Route::get('/products/category/hampers', [ProdukController::class, 'getHampersProducts']);
    Route::get('/products/category/snack', [ProdukController::class, 'getSnackProducts']);

    Route::post('/products/add', [ProdukController::class, 'addProduct']);
    Route::put('/products/edit/{id}', [ProdukController::class, 'editProduct']);
    Route::delete('/products/delete/{id}', [ProdukController::class, 'deleteProduct']);

    //resep
    Route::get('/recipes', [ResepController::class, 'getAllRecipes']);
    Route::get('/recipes/{idProduct}', [ResepController::class, 'getRecipesById']);
    Route::post('/recipes/add', [ResepController::class, 'addRecipe']);
    Route::put('/recipes/edit/{id}', [ResepController::class, 'editRecipe']);
    Route::delete('/recipes/delete/{id}', [ResepController::class, 'deleteRecipe']);

    //bahan baku
    Route::get('/ingredients', [BahanBakuController::class, 'getAllIngredients']);
    Route::post('/ingredients/add', [BahanBakuController::class, 'addIngredient']);
    Route::put('/ingredients/edit/{id}', [BahanBakuController::class, 'editIngredient']);
    Route::delete('/ingredients/delete/{id}', [BahanBakuController::class, 'deleteIngredient']);

    //hampers
    Route::get('/hampers', [HampersController::class, 'getAllHampers']);
    Route::post('/hampers/add', [HampersController::class, 'addHampers']);
    Route::put('/hampers/edit/{idHampers}', [HampersController::class, 'editHampers']);
    Route::delete('/hampers/delete/{idHampers}', [HampersController::class, 'deleteHampers']);

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'getAllKaryawan']);
    Route::post('/karyawan/add', [KaryawanController::class, 'addKaryawan']);
    Route::put('/karyawan/edit/{idkaryawan}', [KaryawanController::class, 'editKaryawan']);
    Route::delete('/karyawan/delete/{idkaryawan}', [KaryawanController::class, 'deleteKaryawan']);

    //penitip
    Route::get('/penitip', [PenitipController::class, 'getAllPenitip']);
    Route::post('/penitip/add', [PenitipController::class, 'addPenitip']);
    Route::put('/penitip/edit/{idPenitip}', [PenitipController::class, 'editPenitip']);
    Route::delete('/penitip/delete/{idPenitip}', [PenitipController::class, 'deletePenitip']);
});
