<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\MConfig;
use App\Models\MUserConfig;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        try {
            $user = User::where('username', $request->username)->first();
            if(!$user){
                throw new \Exception("Account Doesn't Exist");
            }
            if(empty($user->is_email_verified)){
                throw new \Exception("Account Doesn't Active");
            }
            if(!Hash::check($request->password, $user->password)){
                throw new \Exception("Password Not Match");
            }
            $data = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];
            if (Auth::Attempt($data)) {
                $response = [
                    'url' => route('home')
                ];

                return $this->success_response("Login Success", $response, $request->all());
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }
    // use AuthorizesRequests, ValidatesRequests;
    public function register(Request $request) {
        try {
            DB::beginTransaction();
            $request->validate(User::validation()->rules, User::validation()->messages);
            $createUser = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'name' => $request->first_name .' '.$request->last_name,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password)
            ]);
            $token = Str::random(64);

            UserVerify::create([
                'user_id' => $createUser->id,
                'token' => $token
            ]);
            $data = [
                'token' => $token
            ];
            Mail::to($request->email)->send(new SendEmail('emails.verification-account', 'Verify Account', $data));
            DB::commit();

            $response = [
                'url' => route('login')
            ];

            return $this->success_response("Berhasil Membuat Account, Silahkan Periksa Email", $response, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

      return redirect()->route('login')->with('message', $message);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
