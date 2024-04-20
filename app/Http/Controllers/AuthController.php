<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSend;
use App\Mail\VerificationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Customer;
use App\Models\AlamatCustomer;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status' => 'Login failed',
                'message' => 'Invalid username or password',
                'data' => null
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
            'data' => null
        ]);
    }

    public function register(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',

            //customer
            'name' => 'required',
            'phone' => 'required|numeric',
            'addressLabel' => 'required',
            'address' => 'required',
            'birthDate' => 'required',
            'gender' => 'required'
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_role' => $request->id_role ?? 4,
            'verif_key' => Str::random(32),
            'url_foto' => null,
            'tanggal_diverifikasi' => null
        ]);

        $customer = Customer::create([
            'id_user' => $user->id_user,
            'nama_customer' => $request->name,
            'no_telp' => $request->phone,
            'address' => $request->address,
            'jenis_kelamin' => $request->gender,
            'tanggal_lahir' => $request->birthDate,
            'poin' => 0
        ]);

        $alamat = AlamatCustomer::create([
            'label_alamat' => $request->addressLabel,
            'alamat' => $request->address,
            'id_customer' => $customer->id_customer
        ]);

        $details = [
            'url' => request()->getHttpHost() . '/email/verify/' .  $user->id_user . '/' . $user->verif_key
        ];

        if ($user->save()) {
            $customer->save();
            $alamat->save();
            Mail::to($user->email)->send(new VerificationMail($details)); // send email verification
            return response()->json([
                'success' => true,
                'message' => 'Register successful',
                'data' => [
                    'user' => $user,
                    'customer' => $customer,
                    'alamat' => $alamat
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register failed',
                'data' => null
            ]);
        }
    }

    public function notAuthenticated()
    {
        return response()->json([
            'success' => false,
            'message' => 'Not authenticated',
            'data' => null
        ], 401);
    }
}
