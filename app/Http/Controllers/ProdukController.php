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
    public function getAllProducts(Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        try {
            $products = Produk::orderBy('nama_produk')->get();
            $products = $products->map(function ($product) use ($date) {
                $product->stok = $product->stok($date);
                return $product;
            });

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

    public function getCakesProducts(Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        try {
            $cakesProducts = Produk::where('jenis_produk', 'Cake')
                ->orderBy('nama_produk')
                ->get();
            $cakesProducts = $cakesProducts->map(function ($product) use ($date) {
                $product->stok = $product->stok($date);
                return $product;
            });
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

    public function getRotiProducts(Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        try {
            $rotiProducts = Produk::where('jenis_produk', 'Roti')
                ->orderBy('nama_produk')
                ->get();
            $rotiProducts = $rotiProducts->map(function ($product) use ($date) {
                $product->stok = $product->stok($date);
                return $product;
            });
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

    public function getMinumanProducts(Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        try {
            $minumanProducts = Produk::where('jenis_produk', 'Minuman')
                ->orderBy('nama_produk')
                ->get();
            $minumanProducts = $minumanProducts->map(function ($product) use ($date) {
                $product->stok = $product->stok($date);
                return $product;
            });
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

    public function getSnackProducts(Request $request)
    {
        $date = $request->query('date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        try {

            $snackProducts = Produk::where('jenis_produk', 'Snack')
                ->orderBy('nama_produk')
                ->get();
            $snackProducts = $snackProducts->map(function ($product) use ($date) {
                $product->stok = $product->stok($date);
                return $product;
            });
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

    public function getOwnProducts()
    {
        try {
            $products = Produk::whereNotIn('jenis_produk', ['Hampers', 'Snack'])->where('nama_produk', 'not like', '%1/2%')->get();
            return response()->json([
                'success' => true,
                'message' => 'Success Retrive Own Products',
                'data' => [
                    'products' => $products
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve own products',
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
            'deskripsi' => 'required',
            'jenis_produk' => ['required', Rule::in(['Cake', 'Roti', 'Minuman', 'Hampers', 'Snack'])],
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $name = time() . '.' . $foto->getClientOriginalExtension();
            $destinationPath = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . $request->file('foto')->storeAs('products', $name, 'azure');
        }

        try {
            $product = Produk::create([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'limit_produksi' => $request->limit_produksi,
                'jenis_produk' => $request->jenis_produk,
                'id_penitip' => $request->id_penitip,
                'deskripsi' => $request->deskripsi,
                'foto' => $destinationPath
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
            'deskripsi' => 'required',
            'jenis_produk' => ['required', Rule::in(['Cake', 'Roti', 'Minuman', 'Hampers', 'Snack'])],
            'foto' => 'required',
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

    public function addImageProduct(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . $request->file('image')->storeAs('products', $name, 'azure');
        }
        return response()->json([
            'success' => true,
            'message' => 'Image added',
            'data' => ['url' => $destinationPath]
        ], 200);
    }

    public function getProductById(Request $request, $id)
    {
        $date = $request->query('date');
        if (!$date) {
            $date = date('Y-m-d');
        }
        $product = Produk::find($id);
        $product->stok = $product->stok($date);
        if ($product->jenis_produk == 'Hampers') {
            $product->items = $product->detailHampers()->get()->map(function ($item) {
                return $item->items;
            });
        }

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Product found',
            'data' => ['product' => $product]
        ], 200);
    }

    public function getProductWithStock()
    {
        $products = Produk::all();
        $date = date('Y-m-d');

        $products = $products->map(function ($product) use ($date) {
            $product->stok = $product->stok($date);
            return $product;
        });

        return response()->json([
            'success' => true,
            'message' => 'Product found',
            'data' => ['product' => $products]
        ]);
    }
}
