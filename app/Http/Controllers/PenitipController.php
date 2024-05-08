<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penitip;
use Illuminate\Support\Facades\Validator;

class PenitipController extends Controller
{
    public function getAllPenitip()
    {
        try {
            $custodian = Penitip::all();
            return response()->json([
                'success' => true,
                'message' => 'custodian Successfully Retrieved',
                'data' => ['penitip' => $custodian]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve all custodian',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function addPenitip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penitip' => 'required',
            'alamat_penitip' => 'required',
            'telp_penitip' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }

        try {
            $custodian = Penitip::create($request->all());
            $custodian->save();
            return response()->json([
                'success' => true,
                'message' => 'custodian Successfully Added',
                'data' => ['custodian' => $custodian]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add custodian',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function editPenitip(Request $request, $idPenitip)
    {
        $validator = Validator::make($request->all(), [
            'nama_penitip' => 'required',
            'alamat_penitip' => 'required',
            'telp_penitip' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $custodian = Penitip::find($idPenitip);
            if ($custodian == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Custodian Not Found',
                    'data' => null
                ], 404);
            }
            $custodian->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'custodian Successfully Updated',
                'data' => ['custodian' => $custodian]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update custodian',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deletePenitip($idPenitip)
    {
        try {
            $custodian = Penitip::find($idPenitip);
            if ($custodian == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Custodian Not Found',
                    'data' => null
                ], 404);
            }
            $custodian->delete();
            return response()->json([
                'success' => true,
                'message' => 'custodian Successfully Deleted',
                'data' => ['custodian' => $custodian]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete custodian',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getPenitipById($idPenitip)
    {
        try {
            $custodian = Penitip::find($idPenitip);
            if ($custodian == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Custodian Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'custodian Successfully Retrieved',
                'data' => ['custodian' => $custodian]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve custodian',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
