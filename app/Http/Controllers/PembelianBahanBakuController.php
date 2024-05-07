<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelianBahanBaku;
use Illuminate\Support\Facades\Validator;

class PembelianBahanBakuController extends Controller
{
    public function getAllPembelianBahanBaku()
    {
        try {
            $pembelianBahanBaku = PembelianBahanBaku::with('bahan_baku')->get();
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Purchase Successfully Retrieved',
                'data' => ['pembelian_bahan_baku' => $pembelianBahanBaku]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pembelian bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function addPembelianBahanBaku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_pembelian' => 'required',
            'jumlah_pembelian' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'id_bahan_baku' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $pembelianBahanBaku = PembelianBahanBaku::create($request->all());
            $pembelianBahanBaku->save();
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Purchase Successfully Added',
                'data' => ['pembelian_bahan_baku' => $pembelianBahanBaku]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add pembelian bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function editPembelianBahanBaku(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_pembelian' => 'required',
            'jumlah_pembelian' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'id_bahan_baku' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $pembelianBahanBaku = PembelianBahanBaku::find($request->id);
            $pembelianBahanBaku->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Purchase Successfully Updated',
                'data' => ['pembelian_bahan_baku' => $pembelianBahanBaku]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update pembelian bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deletePembelianBahanBaku($id)
    {
        try {
            $pembelianBahanBaku = PembelianBahanBaku::find($id);
            if ($pembelianBahanBaku == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingredients Purchase Not Found',
                    'data' => null
                ], 404);
            }
            $pembelianBahanBaku->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Purchase Successfully Deleted',
                'data' => ['pembelian_bahan_baku' => $pembelianBahanBaku]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete pembelian bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getPembelianBahanBakuById($id)
    {
        try {
            $pembelianBahanBaku = PembelianBahanBaku::with('bahan_baku')->find($id);
            if ($pembelianBahanBaku == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingredients Purchase Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Purchase Successfully Retrieved',
                'data' => ['pembelian_bahan_baku' => $pembelianBahanBaku]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pembelian bahan baku',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
