<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class PushNotificationController extends Controller
{
    public function updateToken(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
                'data' => null
            ], 404);
        }

        $customer->fcmToken = $request->query('fcmToken');
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Token updated successfully',
            'data' => $customer

        ], 200);
    }
}
