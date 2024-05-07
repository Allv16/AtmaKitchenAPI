<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengeluaranLainLain;
use Illuminate\Support\Facades\Validator;

class PengeluaranLainLainController extends Controller
{
    public function getAllPengeluaranLainLain()
    {
        try {
            $pengeluaranLainLain = PengeluaranLainLain::orderBy('tanggal_pengeluaran', 'desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran Lain Lain Successfully Retrieved',
                'data' => ['pengeluaranLainLain' => $pengeluaranLainLain]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive pengeluaran lain lain',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function addPengeluaranLainLain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengeluaran' => 'required',
            'tanggal_pengeluaran' => 'required',
            'total_pengeluaran' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }

        try {
            $pengeluaranLainLain = PengeluaranLainLain::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran Lain Lain Successfully Added',
                'data' => ['pengeluaranLainLain' => $pengeluaranLainLain]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add pengeluaran lain lain',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function updatePengeluaranLainLain(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengeluaran' => 'required',
            'tanggal_pengeluaran' => 'required',
            'total_pengeluaran' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }

        try {
            $pengeluaranLainLain = PengeluaranLainLain::find($id);
            if (!$pengeluaranLainLain) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengeluaran Lain Lain Not Found',
                    'data' => null
                ], 404);
            }
            $pengeluaranLainLain->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran Lain Lain Successfully Updated',
                'data' => ['pengeluaranLainLain' => $pengeluaranLainLain]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update pengeluaran lain lain',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deletePengeluaranLainLain($id)
    {
        try {
            $pengeluaranLainLain = PengeluaranLainLain::find($id);
            if (!$pengeluaranLainLain) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengeluaran Lain Lain Not Found',
                    'data' => null
                ], 404);
            }
            $pengeluaranLainLain->delete();
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran Lain Lain Successfully Deleted',
                'data' => ['pengeluaranLainLain' => $pengeluaranLainLain]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete pengeluaran lain lain',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getPengeluaranLainLainById($id)
    {
        try {
            $pengeluaranLainLain = PengeluaranLainLain::find($id);
            if (!$pengeluaranLainLain) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengeluaran Lain Lain Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran Lain Lain Successfully Retrieved',
                'data' => ['pengeluaranLainLain' => $pengeluaranLainLain]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pengeluaran lain lain',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
