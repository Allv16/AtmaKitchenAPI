<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resep;
use Illuminate\Support\Facades\Validator;

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
}
