<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSend;
use App\Mail\VerificationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

use App\Models\PasswordResetToken;
use App\Models\User;
use App\Models\Customer;
use App\Models\AlamatCustomer;
use App\Mail\ForgetPassword;
use Exception;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;

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
                    'user' => $user->load('customer'),
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

    public function logout()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $user->currentAccessToken()->delete();
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

    public function sendVerification(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }

        $user =  User::where('email', $request->email)->first();

        if ($user && $user->tanggal_diverifikasi != null) {
            $credentials = ['email' => $user->email];
            $response = Password::sendResetLink($credentials);

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return response()->json([
                        'success'  => true,
                        'message' => 'Password reset link send into mail.',
                        'data' => null
                    ], 201);
                case Password::INVALID_USER:
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to send password reset link.',
                        'data' => null
                    ], 401);
            }
        } else {
            return response()->json([
                'success'        => false,
                'message' =>   'Email not found or not verified!',
                'data' => null
            ], 401);
        }
    }

    public function validateForgotPassword(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'token' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        $token = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (Hash::check($request->token, $token->token)) {
            $user = User::where('email', $token->email)->first();
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return view('verification', ['message' => 'Password changed successfully', 'message2' => 'Your password has been successfully updated. Now you can return to the login page to access our website', "class1" => "success", "class2" => "success1"]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Token invalid',
                'data' => null
            ]);
        }
    }

    public function isEmailVerified($username)
    {
        $user = User::where('username', $username)->first();
        if ($user->tanggal_diverifikasi != null) {
            return response()->json([
                'success' => true,
                'message' => 'Email is verified',
                'data' => null
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email is not verified',
                'data' => null
            ]);
        }
    }

    public function editProfilePicture(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }

        try {
            $user = Auth::user();

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $name = $user->email . '.' . $foto->getClientOriginalExtension();
                $destinationPath = env('AZURE_STORAGE_URL') . env('AZURE_STORAGE_CONTAINER') . '/' . $request->file('foto')->storeAs('profiles', $name, 'azure');
            }

            $editedUser = User::find($user->id_user);
            $editedUser = $editedUser->update([
                'url_foto' => $destinationPath
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'ERROR: ' . $e->getMessage(),
                'data' => null
            ], 400);
        }
    }

    public function isUsernameAvailable($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'Username is available',
                'data' => null
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username is taken',
                'data' => null
            ]);
        }
    }

    public function isEmailAvailable($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'Email is available',
                'data' => null
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email is taken',
                'data' => null
            ]);
        }
    }

    public function getProfile()
    {
        $userID = Auth::id();
        $customer = Customer::where('id_user', $userID)->first();
        return response()->json([
            'success' => true,
            'message' => 'Profile fetched',
            'data' => [
                'customer' => $customer->load('user', 'saldo')
            ]
        ]);
    }


    public function editProfile(Request $request, $idCustomer)
    {
        $validators = Validator::make($request->all(), [
            'nama_customer' => 'required',
            'no_telp' => 'required|numeric',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required'
        ]);
        if ($validators->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validators->errors(),
                'data' => null
            ], 400);
        }
        try {
            $customer = Customer::find($idCustomer);
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer not found',
                    'data' => null
                ], 404);
            }
            $customer->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Customer updated',
                'data' => $customer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update customer',
                'error' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'message' => 'User fetched',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function getAllCustomer()
    {
        $customer = Customer::all();
        return response()->json([
            'success' => true,
            'message' => 'User fetched',
            'data' => [
                'customer' => $customer
            ]
        ]);
    }

    public function change_password(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validators->fails()) {
            return response()->json([
                'message' => 'Validation fails',
                'errors' => $validators->errors()
            ], 401);
        }

        $id = Auth::id();
        $updatedUser = User::find($id);
        if (Hash::check($request->old_password, $updatedUser->password)) {
            $updatedUser->update([
                'password' => bcrypt($request->new_password)
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Password Succesfully updated',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Old password does not matched',

            ], 401);
        }
    }
}
