<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    public function getKeranjang(Request $request)
    {
        $id_customer = $request->query('id');
        $date = $request->query('date');
        $keranjang = [];
        $keranjang = Keranjang::where('id_customer', $id_customer)
            ->whereDate('tanggal_keranjang', $date)
            ->get();
        $keranjang = $keranjang->map(function ($item) use ($date) {
            $item->produk->stok = $item->produk->stok($date);
            return $item;
        });
        return response()->json([
            'success' => true,
            'message' => 'Keranjang Successfully Retrieved',
            'data' => ['keranjang' => $keranjang],
        ], 200);
    }

    public function incrementKeranjang($id)
    {
        $keranjang = Keranjang::find($id);
        $keranjang->jumlah_item_keranjang += 1;
        $keranjang->save();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang Successfully Incremented',
            'data' => ['keranjang' => $keranjang],
        ], 200);
    }

    public function decrementKeranjang($id)
    {
        $keranjang = Keranjang::find($id);
        $keranjang->jumlah_item_keranjang -= 1;
        $keranjang->save();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang Successfully Decremented',
            'data' => ['keranjang' => $keranjang],
        ], 200);
    }

    public function deleteKeranjang($id)
    {
        $keranjang = Keranjang::find($id);
        $keranjang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang Successfully Deleted',
            'data' => ['keranjang' => $keranjang],
        ], 200);
    }

    public function addKeranjang(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'id_customer' => 'required',
            'id_produk' => 'required',
            'jumlah_item_keranjang' => 'required',
            'tanggal_keranjang' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        try {
            $keranjang = Keranjang::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Keranjang Successfully Added',
                'data' => ['keranjang' => $keranjang],
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
