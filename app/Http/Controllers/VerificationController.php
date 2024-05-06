<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class VerificationController extends Controller
{
    public function verify($id, $hash)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->tanggal_diverifikasi != null) {
                return view('verification', ['message' => 'Email already verified', 'message2' => 'Your account has been activated, so no further verification is required.', "class1" => "warning", "class2" => "warning1"]);
            } else {
                if ($user->verif_key == $hash) {
                    $user->tanggal_diverifikasi = now();
                    $user->save();
                    return view('verification', ['message' => 'Email verified successfully', 'message2' => 'Your account is now fully activated. Explore our website for more features and updates.', "class1" => "success", "class2" => "success1"]);
                } else {
                    return view('verification', ['message' => 'Invalid verification link']);
                }
            }
        } else {
            return view('verification', ['message' => 'Invalid verification link']);
        }
    }
    

    public function resend($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user->tanggal_diverifikasi == null) {
                $user->verif_key = Str::random(32);
                $details = [
                    'url' => request()->getHttpHost() . '/email/verify/' .  $user->id_user . '/' . $user->verif_key
                ];
                $user->save();
                if ($user->save()) {
                    Mail::to($user->email)->send(new VerificationMail($details)); // send email verification
                    return response()->json([
                        'success' => true,
                        'message' => 'New verification link sent successfully',
                        'data' => null
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to send new verification link',
                        'data' => null
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already verified',
                    'data' => null
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "User not found",
                'data' => null
            ]);
        }
    }
}
