<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MutasiSaldo;
use App\Models\PengembalianDana;
use Illuminate\Support\Facades\Validator;

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

    public function requestWithdraw(Request $request, $idCustomer)
    {
        $validator = Validator::make($request->all(), [
            'nomor_rekening_tujuan' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $tanggalDiajukan = date('Y-m-d H:i:s');
        $nomorRekening = $request->input('nomor_rekening_tujuan');

        $saldo = MutasiSaldo::where('id_customer', $idCustomer)->orderBy('tanggal_mutasi', 'desc')->first();
        $jumlahPengembalian = $saldo->saldo;
        if (!$saldo || $saldo->saldo < $jumlahPengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient Balance'
            ], 400);
        }

        $withdrawRequest = PengembalianDana::create([
            'id_customer' => $idCustomer,
            'jumlah_pengembalian' => $jumlahPengembalian,
            'tanggal_pengembalian_diajukan' => $tanggalDiajukan,
            'tanggal_pengembalian_diterima' => null,
            'nomor_rekening_tujuan' => $nomorRekening,
            'status_pengembalian' => 'Waiting Confirmation'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Withdraw Request Submitted Successfully',
            'data' => $withdrawRequest
        ], 201);
    }

    public function getWithdrawForAdminTodo()
    {
        try {
            $pengembalianDana = PengembalianDana::where('status_pengembalian', 'Waiting Confirmation')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Saldo Refund Successfully Retrieved',
                'data' => ['refund' => $pengembalianDana->load('customer')]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive saldo refund',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function confirmWithdraw($id)
    {
        $withdrawRequest = PengembalianDana::find($id);

        if (!$withdrawRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Withdraw Request Not Found'
            ], 404);
        }

        $saldo = MutasiSaldo::where('id_customer', $withdrawRequest->id_customer)->orderBy('tanggal_mutasi', 'desc')->first();

        if (!$saldo || $saldo->saldo < $withdrawRequest->jumlah_pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient Balance'
            ], 400);
        }

        MutasiSaldo::create([
            'id_customer' => $withdrawRequest->id_customer,
            'debit' => 0,
            'kredit' => $withdrawRequest->jumlah_pengembalian,
            'saldo' => $saldo->saldo - $withdrawRequest->jumlah_pengembalian,
            'tanggal_mutasi' => now()
        ]);

        $withdrawRequest->status_pengembalian = 'Confirmed';
        $withdrawRequest->tanggal_pengembalian_diterima = now();
        $withdrawRequest->save();

        return response()->json([
            'success' => true,
            'message' => 'Withdraw Request Confirmed Successfully',
            'data' => $withdrawRequest
        ], 200);
    }

    public function getWithdrawByIdCustomer($idCustomer)
    {
        try {
            $pengembalianDana = PengembalianDana::where('id_customer', $idCustomer)
                ->orderBy('tanggal_pengembalian_diajukan', 'desc')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Saldo Refund Successfully Retrieved',
                'data' => ['refund' => $pengembalianDana]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive saldo refund',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
