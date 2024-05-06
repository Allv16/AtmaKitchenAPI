<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function getAllKaryawan()
    {
        try {
            $karyawan = Karyawan::all();
            return response()->json([
                'success' => true,
                'message' => 'Karyawan Successfully Retrieved',
                'data' => ['karyawan' => $karyawan]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive hampers',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function addKaryawan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_karyawan' => 'required',
            'gaji_karyawan' => 'required|numeric',
            'bonus_gaji_karyawan' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $karyawan = Karyawan::create($request->all());
            $karyawan->save();
            return response()->json([
                'success' => true,
                'message' => 'Karyawan Successfully Added',
                'data' => ['karyawan' => $karyawan]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add karyawan',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getKaryawanById($id)
    {
        try {
            $karyawan = Karyawan::find($id);
            if ($karyawan == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Karyawan Successfully Retrieved',
                'data' => ['karyawan' => $karyawan]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve karyawan',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function editKaryawan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_karyawan' => 'required',
            'gaji_karyawan' => 'required|numeric',
            'bonus_gaji_karyawan' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        }

        try {
            $karyawan = Karyawan::find($id);
            if ($karyawan == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan Not Found',
                    'data' => null
                ], 404);
            }
            $karyawan->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Karyawan Successfully Updated',
                'data' => ['karyawan' => $karyawan]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update karyawan',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deleteKaryawan($idKaryawan)
    {
        try {
            $karyawan = Karyawan::find($idKaryawan);
            if ($karyawan == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan Not Found',
                    'data' => null
                ], 404);
            }
            $karyawan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Karyawan Successfully Deleted',
                'data' => ['karyawan' => $karyawan]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete karyawan',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getKaryawanById($idKaryawan)
    {
        try {
            $karyawan = Karyawan::find($idKaryawan);
            if ($karyawan == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Karyawan Successfully Retrieved',
                'data' => ['karyawan' => $karyawan]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrive karyawan',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
