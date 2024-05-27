<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function payTransaction(Request $request, $id)
    {
        $validators = Validator::make($request->all(), [
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        try {

            if ($request->hasFile('bukti_pembayaran')) {
                $foto = $request->file('bukti_pembayaran');
                $name = time() . '.' . $foto->getClientOriginalExtension();
                $destinationPath = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . $request->file('bukti_pembayaran')->storeAs('bukti_pembayaran', $name, 'azure');
            }

            $pembayaran = Pembayaran::find($id);
            if (!$pembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran not found',
                    'data' => null
                ], 404);
            }

            $transaksi = $pembayaran->transaksi;
            $transaksi->status_transaksi = 'Paid';
            $pembayaran->bukti_pembayaran = $destinationPath;
            $pembayaran->tanggal_pembayaran = date('Y-m-d H:i:s');
            $pembayaran->save();
            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Successfully Updated',
                'data' => ['pembayaran' => $pembayaran],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function confirmPayment(Request $request, $id)
    {
        $validators = Validator::make($request->all(), [
            'total_pembayaran' => 'required',
            'tip' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        try {
            $pembayaran = Pembayaran::find($id);
            if (!$pembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran not found',
                    'data' => null
                ], 404);
            }

            $pembayaran->transaksi->status_transaksi = 'Payment Valid';
            $pembayaran->transaksi->save();

            $pembayaran->tanggal_pembayaran_valid = date('Y-m-d H:i:s');
            $pembayaran->total_pembayaran = $request->total_pembayaran;
            $pembayaran->tip = $request->tip;
            $pembayaran->save();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran Successfully Confirmed',
                'data' => ['pembayaran' => $pembayaran],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
