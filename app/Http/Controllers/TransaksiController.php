<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\DetailTransaksi;


class TransaksiController extends Controller
{
    public function getAllTransactionByIdCustomer($id_customer)
    {
        try {
            $transaksi = Transaksi::where('id_customer', $id_customer)->orderBy('tanggal_nota_dibuat', 'desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => ['transaksi' => $transaksi->load(['detailTransaksi.produk', 'pembayaran'])]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getHistoryTransactionByIdCustomer($id_customer)
    {
        try {
            $transaksi = Transaksi::where('id_customer', $id_customer)->where(function ($query) {
                $query->where('status_transaksi', 'Selesai')->orWhere('status_transaksi', 'Ditolak')->orWhere('status_transaksi', 'Diproses');
            })->get()->load('detailTransaksi.produk');
            return response()->json([
                'success' => true,
                'message' => 'Transaction Successfully Retrieved',
                'data' => $transaksi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive transaction',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
