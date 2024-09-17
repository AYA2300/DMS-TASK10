<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class VerificationController extends Controller
{
    public function verify(Request $request){


        $request->validate([
            'user_id' => 'required|exists:users,id',
            'verification_code' => 'required|string',
        ]);
        $user=User::find($request->user_id);
       // dd($user->verification_code);

        if ($request->verification_code===$user->verification_code ) {

            $user->is_verified = true;
            $user->verification_code = null;
            $user->save();

            return response()->json([
                'message' => 'Email verified successfully!',
            ]);

        }else{
         return response()->json(['error' => 'Invalid verification code'], 422);}




    }

    public function rest_pass(Request $request){

        $request->validate([

            'reset_code' => 'required|string',
            'email'=>'required|email',
            'new_password' => 'required|string|min:8',

        ]);

        $user=User::where('email',$request->email)->where('reset_code',$request->reset_code)->first();

        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->new_password);
        $user->reset_code = null;  // مسح كود التأكيد بعد استخدامه
        $user->save();

        return response()->json(['message' => 'Password successfully updated']);
    }





    public function reset_code(Request $request){

        $request->validate([
            'email'=>'required|email',

        ]);
        $restcode=Str::random(6);

        $user=User::where('email',$request->email)->first();
        $user->reset_code=$restcode;
        $user->save();



        Mail::raw("Your password reset code is: $restcode", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Password Reset Code');
        });

        return response()->json(['message' => 'Reset code sent to your email']);











    }

}
