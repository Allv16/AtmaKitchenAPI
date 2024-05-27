<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MutasiSaldo;

class SaldoController extends Controller
{
    public function getSaldo($idCustomer)
    {
        $saldo = MutasiSaldo::where('id_customer', $idCustomer)->orderBy('tanggal_mutasi', 'desc')->first();
        return response()->json([
            'success' => true,
            'message' => 'Transaction Successfully Updated',
            'data' => ['Saldo' => $saldo]
        ], 200);
    }
}
