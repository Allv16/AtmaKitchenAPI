<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlamatCustomer;

class AlamatController extends Controller
{
    public function getAlamatByIdCustomer($id)
    {
        $alamat = AlamatCustomer::where('id_customer', $id)->get();

        if (!$alamat) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Alamat Successfully Retrieved',
            'data' => $alamat
        ], 200);
    }
}
