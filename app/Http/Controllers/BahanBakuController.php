<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Validator;

class BahanBakuController extends Controller
{
    public function getAllIngredients()
    {
        try {
            $ingredients = BahanBaku::all();
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Successfully Retrieved',
                'data' => ['ingredients' => $ingredients]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve all ingredients',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getIngredientsById($id)
    {
        try {
            $ingredient = BahanBaku::find($id);
            if ($ingredient == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingredient Not Found',
                    'data' => null
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Ingredient Successfully Retrieved',
                'data' => ['ingredient' => $ingredient]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve ingredient',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function addIngredient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan_baku' => 'required',
            'satuan' => 'required',
            'stok' => 'required|integer',
            'min_stok' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $Ingredient = BahanBaku::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Ingredient Successfully Added',
                'data' => ['ingredient' => $Ingredient]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add ingredient',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function editIngredient(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan_baku' => 'required',
            'satuan' => 'required',
            'stok' => 'required|integer',
            'min_stok' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
                'data' => null
            ], 400);
        }
        try {
            $ingredient = BahanBaku::find($id);
            if ($ingredient == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe Not Found',
                    'data' => null
                ], 404);
            }
            $ingredient->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'ingredient Successfully Updated',
                'data' => ['ingredient' => $ingredient]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update ingredient',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function deleteIngredient($id)
    {
        try {
            $ingredient = BahanBaku::find($id);
            if ($ingredient == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingredient Not Found',
                    'data' => null
                ], 404);
            }
            $ingredient->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ingredient Successfully Deleted',
                'data' => ['ingredient' => $ingredient]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete ingredient',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getLowIngredients()
    {
        try {
            $ingredients = BahanBaku::whereColumn('stok', '<', 'min_stok')->get();
            return response()->json([
                'success' => true,
                'message' => 'Ingredients Successfully Retrieved',
                'data' => ['ingredients' => $ingredients]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve all ingredients',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
