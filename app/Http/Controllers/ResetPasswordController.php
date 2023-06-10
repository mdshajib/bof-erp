<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetSuccessMail;

class ResetPasswordController extends Controller
{
    public function emailVerify(Request $request){
        try {
            $request->validate(['email' => 'required|email']);
            $user =  DB::table('users')
                ->select('id','email')
                ->where('email', trim($request->email))
                ->first();
            if(!$user){
                return back()->withErrors(['Email not found.']);
            }
            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email'      => $user->email,
                'token'      => $token,
                'created_at' => Carbon::now()
            ]);

            $data = $token . '?email=' . $user->email;

            Mail::send('email.password_reset_link_mail', ['token' => $data], function($message) use($user){
                $message->to($user->email);
                $message->subject('Reset your Password');
            });

            return back()->with('status', 'We have e-mailed your password reset link!');
        }catch(\Exception $ex){
            return back()->with('status', $ex->getMessage());
        }
    }

    public function resetPasswordForm(Request $request, $token) {
        abort_if(! DB::table('password_resets')->select('email')
            ->where(['email' => trim($request->email), 'token' => trim($token)])
            ->exists(), 404);
        return view('auth.reset-password', ['request' => $request]);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ],[
            'password.min' => 'The password must be at least 6 characters'
        ]);

        $token = DB::table('password_resets')->select('email')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();
        if(!$token){
            return back()->withErrors(['Invalid token!']);
        }
        DB::table('users')->where('email', $token->email)
            ->update(['password' => bcrypt($request->password) , 'updated_at' => Carbon::now()]);
        DB::table('password_resets')->where('email', $token->email)->delete();
        Mail::to($request->email)->send(new PasswordResetSuccessMail());
        return redirect()->route('login')->with('status', 'Your password has been changed!');
    }
}
