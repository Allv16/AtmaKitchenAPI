<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\PenggunaanBahanBaku;
use Illuminate\Support\Facades\Validator;

class PenggunaanBahanBakuController extends Controller
{

    public function getAllPenggunaanBahanBaku()
    {
        try {
            $penggunaanBahanBaku = PenggunaanBahanBaku::with('bahan_baku')->get();
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Purchase Successfully Retrieved',
                'data' => ['penggunaan_bahan_baku' => $penggunaanBahanBaku]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve penggunaan bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
    public function addPenggunaanBahanBaku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bahan_baku' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $bahan_baku = $request->bahan_baku;

            foreach ($bahan_baku as $b) {
                $bahan_baku = BahanBaku::find($b['id_bahan_baku']);
                $bahan_baku->stok -= $b['jumlah_bahan'];
                $bahan_baku->save();

                PenggunaanBahanBaku::create([
                    'id_bahan_baku' => $b['id_bahan_baku'],
                    'jumlah_penggunaan' => $b['jumlah_bahan'],
                    'tanggal_penggunaan' => date('Y-m-d H:i:s')
                ]);
            }


            return response()->json([
                'success' => true,
                'message' => 'Ingredients Use Successfully Added',
                'data' => ['penggunaan_bahan_baku' => $bahan_baku]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add penggunaan bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
