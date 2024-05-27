<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use Illuminate\Support\Facades\Validator;
use App\Models\Produk;
use App\Models\BahanBaku;
use App\Models\Transaction;
use App\Models\Transaksi;

class ResepController extends Controller
{
    public function getAllRecipes()
    {
        try {
            $recipes = Resep::all();
            return response()->json([
                'success' => true,
                'message' => 'Recipes Successfully Retrieved',
                'data' => ['recipe' => $recipes->load(['produk', 'bahanBaku'])]
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

    public function getRecipesById($idProduct)
    {
        try {
            $recipe = Resep::where('id_produk', $idProduct)->get();
            if ($recipe->count() == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe Not Found',
                    'data' => null
                ], 404);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Recipe Successfully Retrieved',
                    'data' => ['recipe' => $recipe->load(['produk', 'bahanBaku'])]
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recipe',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function addRecipe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_bahan' => 'required|integer',
            'id_produk' => 'required|integer',
            'id_bahan_baku' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $recipe = Resep::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Recipe Successfully Added',
                'data' => ['recipe' => $recipe]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add recipe',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function editRecipe(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_bahan' => 'required|integer',
            'id_produk' => 'required|integer',
            'id_bahan_baku' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $recipe = Resep::find($id);
            if ($recipe == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe Not Found',
                    'data' => null
                ], 404);
            }
            $recipe->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Recipe Successfully Updated',
                'data' => ['recipe' => $recipe]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update recipe',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function updateRecipeByIdProduct(Request $request, $id)
    {
        try {
            $newRecipes = $request->all();

            $updatedRecipes = [];

            Resep::where('id_produk', $id)->delete();
            foreach ($newRecipes as $newRecipe) {
                $recipe = Resep::updateOrCreate(
                    ['id_bahan_baku' => $newRecipe['id_bahan_baku'], 'id_produk' => $id],
                    ['jumlah_bahan' => $newRecipe['jumlah_bahan']]
                );
                $updatedRecipes[] = $recipe;
            }
            return response()->json([
                'success' => true,
                'message' => 'Recipe Successfully Updated',
                'data' => ['recipe' => $updatedRecipes]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deleteRecipe($id)
    {
        try {
            $recipe = Resep::find($id);
            if ($recipe == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe Not Found',
                    'data' => null
                ], 404);
            }
            $recipe->delete();
            return response()->json([
                'success' => true,
                'message' => 'Recipe Successfully Deleted',
                'data' => ['recipe' => $recipe]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete recipe',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getIngredientsForTransaction($idTransaction)
    {
        $transaction = Transaksi::find($idTransaction);

        if ($transaction == null) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
                'data' => null
            ], 404);
        }

        try {
            $receipe = $transaction->detailTransaksi->flatMap(function ($item) {
                if ($item->produk->jenis_produk == 'Hampers') {
                    return $item->produk->detailHampers->flatMap(function ($detailHampers) use ($item) {
                        return $detailHampers->items->resep->map(function ($resep) use ($item) {
                            $resep->jumlah_bahan *= $item->jumlah_item;
                            return $resep;
                        });
                    });
                } else {
                    return $item->produk->resep->map(function ($resep) use ($item) {
                        $resep->jumlah_bahan *= $item->jumlah_item;
                        return $resep;
                    });
                }
            });


            $groupedRecipes = $receipe->groupBy('id_bahan_baku')->map(function ($items) {
                return [
                    'id_bahan_baku' => $items[0]->id_bahan_baku,
                    'jumlah_bahan' => $items->sum('jumlah_bahan'),
                    'bahan_baku' => $items[0]->bahanBaku
                ];
            })->values();

            return response()->json([
                'success' => true,
                'message' => 'Ingredients retrieved successfully',
                'data' => ['ingredients' => $groupedRecipes]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the ingredients',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}
