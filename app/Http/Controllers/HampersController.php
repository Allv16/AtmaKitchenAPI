<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailHampers;
use App\Models\Produk;
use Illuminate\Support\Facades\Validator;


class HampersController extends Controller
{
    public function getAllHampers()
    {
        try {
            $hampers = DetailHampers::with('hampers', 'items')->get();
            $groupedHampers = [];
            foreach ($hampers as $h) {
                $hampersName = $h->hampers->nama_produk;

                if (!isset($groupedHampers[$hampersName])) {
                    $groupedHampers[$hampersName] = [
                        'hampers' => $h->hampers,
                        'items' => []
                    ];
                }
                $groupedHampers[$hampersName]['items'][] = $h->items->toArray();
            }
            $groupedHampers = array_values($groupedHampers);

            // $groupedHampers = $hampers->groupBy('hampers.nama_produk')->map(function ($group) {
            //     return [
            //         'hampers' => $group->first()->hampers,
            //         'items' => $group->pluck('items')->flatten()->toArray(),
            //     ];
            // });
            return response()->json([
                'success' => true,
                'message' => 'Hampers Successfully Retrieved',
                'data' => ['hampers' => $groupedHampers]
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


    public function addHampers(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_hampers' => 'required',
            'harga' => 'required|numeric',
            'limit_produksi' => 'required|numeric',
            'items' => 'required|array',
            'id_kemasan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }

        try {
            $hampers = Produk::create([
                'nama_produk' => $request->nama_hampers,
                'harga' => $request->harga,
                'limit_produksi' => $request->limit_produksi,
                'jenis_produk' => 'Hampers',
                'deskripsi' => $request->deskripsi,
                'foto' => $request->foto
            ]);
            $hampers->save();
            foreach ($request->items as $item) {
                $detailHampers = DetailHampers::create([
                    'id_hampers' => $hampers->id_produk,
                    'id_produk' => $item,
                    'id_kemasan' => $request->id_kemasan
                ]);
                $detailHampers->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Hampers Successfully Added',
                'data' => ['hampers' => $hampers]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add hampers',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function editHampers(Request $request, $idHampers)
    {
        $validator = Validator::make($request->all(), [
            'nama_hampers' => 'required',
            'harga' => 'required|numeric',
            'limit_produksi' => 'required|numeric',
            'items' => 'required|array',
            'id_kemasan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }

        try {
            $hampers = Produk::find($idHampers);
            if ($hampers == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hampers Not Found',
                    'data' => null
                ], 404);
            }
            $hampers->nama_produk = $request->nama_hampers;
            $hampers->harga = $request->harga;
            $hampers->limit_produksi = $request->limit_produksi;
            $hampers->jenis_produk = 'Hampers';
            $hampers->deskripsi = $request->deskripsi;
            $hampers->foto = $request->foto;

            $hampers->save();

            DetailHampers::where('id_hampers', $idHampers)->delete();
            $items = [];
            foreach ($request->items as $item) {
                $detailHampers = DetailHampers::create([
                    'id_hampers' => $hampers->id_produk,
                    'id_produk' => $item,
                    'id_kemasan' => $request->id_kemasan
                ]);
                $detailHampers->save();
                $items[] = $detailHampers;
            }

            return response()->json([
                'success' => true,
                'message' => 'Hampers Successfully Edited',
                'data' => [
                    'hampers' => $hampers->load('detailHampers.items'),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to edit hampers',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deleteHampers($idHampers)
    {
        try {
            $hampers = Produk::find($idHampers);
            if ($hampers == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hampers Not Found',
                    'data' => null
                ], 404);
            }
            $hampers->detailHampers()->delete();
            $hampers->delete();
            return response()->json([
                'success' => true,
                'message' => 'Hampers Successfully Deleted',
                'data' => ['hampers' => $hampers]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete hampers',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getHampersById($idHampers)
    {
        try {
            $hampers = Produk::with('detailHampers.items')->find($idHampers);
            if ($hampers == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hampers Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Hampers Successfully Retrieved',
                'data' => ['hampers' => $hampers]
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
}
