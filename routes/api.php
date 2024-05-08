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
use App\Http\Controllers\PembelianBahanBakuController;
use App\Http\Controllers\PengeluaranLainLainController;
use App\Http\Controllers\TransaksiController;

//Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/email/resend/{email}', [VerificationController::class, 'resend']);
Route::get('/not-authenticated', [AuthController::class, 'notAuthenticated'])->name('not-authenticated');
Route::post('/reset-password', [AuthController::class, 'sendVerification']);
Route::get('/reset-password/{resetToken}', [AuthController::class, 'resetPassword']);
Route::post('/validate-forgot-password', [AuthController::class, 'validateForgotPassword']);
Route::get('/auth/usermame/is-available/{username}', [AuthController::class, 'isUsernameAvailable']);
Route::get('/auth/email/is-available/{email}', [AuthController::class, 'isEmailAvailable']);
Route::get('/auth/email/is-verified/{username}', [AuthController::class, 'isEmailVerified']);
Route::post('/product/upload-photo', [ProdukController::class, 'addImageProduct']);



//Role
Route::get('/roles', [RoleController::class, 'getAllRoles']);


Route::middleware('auth:sanctum')->group(function () {

    //Auth
    Route::post('/auth/edit/profile-picture', [AuthController::class, 'editProfilePicture']);
    Route::get('/auth/profile', [AuthController::class, 'getProfile']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'getUser']);
    Route::post('/auth/user/change-password', [AuthController::class, 'change_password']);

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
    Route::get('/products/{id}', [ProdukController::class, 'getProductById']);


    Route::post('/products/add', [ProdukController::class, 'addProduct']);
    Route::put('/products/edit/{id}', [ProdukController::class, 'editProduct']);
    Route::delete('/products/delete/{id}', [ProdukController::class, 'deleteProduct']);

    //resep
    Route::get('/recipes', [ResepController::class, 'getAllRecipes']);
    Route::get('/recipes/{idProduct}', [ResepController::class, 'getRecipesById']);
    Route::post('/recipes/add', [ResepController::class, 'addRecipe']);
    // Route::put('/recipes/edit/{id}', [ResepController::class, 'editRecipe']);
    Route::put('/recipes/edit/{id}', [ResepController::class, 'updateRecipeByIdProduct']);
    Route::delete('/recipes/delete/{id}', [ResepController::class, 'deleteRecipe']);

    //bahan baku
    Route::get('/ingredients', [BahanBakuController::class, 'getAllIngredients']);
    Route::get('/ingredients/{id}', [BahanBakuController::class, 'getIngredientsById']);
    Route::post('/ingredients/add', [BahanBakuController::class, 'addIngredient']);
    Route::put('/ingredients/edit/{id}', [BahanBakuController::class, 'editIngredient']);
    Route::delete('/ingredients/delete/{id}', [BahanBakuController::class, 'deleteIngredient']);

    //hampers
    Route::get('/hampers', [HampersController::class, 'getAllHampers']);
    Route::get('/hampers/{idHampers}', [HampersController::class, 'getHampersById']);
    Route::post('/hampers/add', [HampersController::class, 'addHampers']);
    Route::put('/hampers/edit/{idHampers}', [HampersController::class, 'editHampers']);
    Route::delete('/hampers/delete/{idHampers}', [HampersController::class, 'deleteHampers']);

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'getAllKaryawan']);
    Route::get('/karyawan/{idKaryawan}', [KaryawanController::class, 'getKaryawanById']);
    Route::post('/karyawan/add', [KaryawanController::class, 'addKaryawan']);
    Route::get('/karyawan/{idKaryawan}', [KaryawanController::class, 'getKaryawanById']);
    Route::put('/karyawan/edit/{idkaryawan}', [KaryawanController::class, 'editKaryawan']);
    Route::delete('/karyawan/delete/{idkaryawan}', [KaryawanController::class, 'deleteKaryawan']);
    //Absen
    Route::post('/karyawan/absen', [KaryawanController::class, 'absentKaryawan']);
    Route::get('/karyawan/absen/{date}', [KaryawanController::class, 'getAbsentKaryawan']);
    Route::delete('/karyawan/absen/{id}', [KaryawanController::class, 'deleteAbsentKaryawan']);



    //penitip
    Route::get('/penitip', [PenitipController::class, 'getAllPenitip']);
    Route::get('/penitip/{idPenitip}', [PenitipController::class, 'getPenitipById']);
    Route::post('/penitip/add', [PenitipController::class, 'addPenitip']);
    Route::get('/penitip/{idPenitip}', [PenitipController::class, 'getPenitipById']);
    Route::put('/penitip/edit/{idPenitip}', [PenitipController::class, 'editPenitip']);
    Route::delete('/penitip/delete/{idPenitip}', [PenitipController::class, 'deletePenitip']);

    //Pembelian bahan baku
    Route::get('/pembelian-bahan-baku', [PembelianBahanBakuController::class, 'getAllPembelianBahanBaku']);
    Route::get('/pembelian-bahan-baku/{id}', [PembelianBahanBakuController::class, 'getPembelianBahanBakuById']);
    Route::post('/pembelian-bahan-baku/add', [PembelianBahanBakuController::class, 'addPembelianBahanBaku']);
    Route::put('/pembelian-bahan-baku/edit/{id}', [PembelianBahanBakuController::class, 'editPembelianBahanBaku']);
    Route::delete('/pembelian-bahan-baku/delete/{id}', [PembelianBahanBakuController::class, 'deletePembelianBahanBaku']);

    //pengeluaran lain lain
    Route::get('/pengeluaran-lain-lain', [PengeluaranLainLainController::class, 'getAllPengeluaranLainLain']);
    Route::get('/pengeluaran-lain-lain/{id}', [PengeluaranLainLainController::class, 'getPengeluaranLainLainById']);
    Route::post('/pengeluaran-lain-lain/add', [PengeluaranLainLainController::class, 'addPengeluaranLainLain']);
    Route::put('/pengeluaran-lain-lain/edit/{id}', [PengeluaranLainLainController::class, 'updatePengeluaranLainLain']);
    Route::delete('/pengeluaran-lain-lain/delete/{id}', [PengeluaranLainLainController::class, 'deletePengeluaranLainLain']);

    //Transaksi
    Route::get('/transaksi/{id}', [TransaksiController::class, 'getAllTransactionByIdCustomer']);
});
