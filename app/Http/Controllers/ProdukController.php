<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ProdukController extends Controller
{
    public function getAllProducts()
    {
        try {
            $products = Produk::all()
                ->sortBy('nama_produk');
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive All Products',
                'data' => [
                    'products' => $products
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve all products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }


    public function getTopProduct()
    {
        try {
            $topSellingProducts = DetailTransaksi::select('id_produk', DB::raw('count(*) as total'))
                ->groupBy('id_produk')
                ->orderByDesc('total')
                ->take(3)
                ->get();

            $top3ProductIds = $topSellingProducts->pluck('id_produk')->toArray();
            $top3Products = Produk::whereIn('id_produk', $top3ProductIds)->get();

            return response()->json([
                'success' => true,
                'message' => 'Success Retrive Top 3 products',
                'data' => [
                    'products' => $top3Products
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve top 3 products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getRandomProducts()
    {
        try {
            $randomProducts = Produk::inRandomOrder()->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive Random 3 products',
                'data' => [
                    'products' => $randomProducts
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve random 3 products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getCakesProducts()
    {
        try {
            $cakesProducts = Produk::where('jenis_produk', 'Cake')
                ->orderBy('nama_produk')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive cakes products',
                'data' => [
                    'products' => $cakesProducts
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cakes products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getRotiProducts()
    {
        try {
            $rotiProducts = Produk::where('jenis_produk', 'Roti')
                ->orderBy('nama_produk')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive roti products',
                'data' => [
                    'products' => $rotiProducts
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve roti products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getMinumanProducts()
    {
        try {
            $minumanProducts = Produk::where('jenis_produk', 'Minuman')
                ->orderBy('nama_produk')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive minuman products',
                'data' => [
                    'products' => $minumanProducts
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve minuman products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getHampersProducts()
    {
        try {
            $hampersProducts = Produk::where('jenis_produk', 'Hampers')
                ->orderBy('nama_produk')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive hampers products',
                'data' => [
                    'products' => $hampersProducts
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hampers products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getSnackProducts()
    {
        try {
            $snackProducts = Produk::where('jenis_produk', 'Snack')
                ->orderBy('nama_produk')
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive snack products',
                'data' => [
                    'products' => $snackProducts
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve snack products',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    //add
    public function addProduct(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required',
            'limit_produksi' => 'required',
            'jenis_produk' => ['required', Rule::in(['Cake', 'Roti', 'Minuman', 'Hampers', 'Snack'])],
        ]);
        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        try {
            $product = Produk::create([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'limit_produksi' => $request->limit_produksi,
                'jenis_produk' => $request->jenis_produk,
                'id_penitip' => $request->id_penitip
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Product created',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    //edit
    public function editProduct(Request $request, $id)
    {
        $validators = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required',
            'limit_produksi' => 'required',
            'jenis_produk' => ['required', Rule::in(['Cake', 'Roti', 'Minuman', 'Hampers', 'Snack'])],
        ]);
        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        try {
            $product = Produk::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'data' => null
                ], 404);
            }
            $product->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Product updated',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    //delete
    public function deleteProduct($id)
    {
        try {
            $product = Produk::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                    'data' => null
                ], 404);
            }
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
