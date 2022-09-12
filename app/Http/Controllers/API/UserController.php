<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use PasswordValidationRules;


    public function login(Request $request){
        try{
            //Validasi input
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            //cek  credentials (login)
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }

            //Jika hash tdk sesuai, maka sampaikan pesan error
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])){
                throw new \Exception('Invalid Credentials');
            }

            //jika berhasil maka biarkan masuk
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');

        } catch(Exception $error){
            return ResponseFormatter::error([
                'message' => 'Pastikan email dan password benar..',
                'error' => $error
            ], 'Authantication Failed', 500);
        }
    }

    public function register(Request $request){
        try {
            $validator = Validator::make($request->all(),[
                'name'=> ['required', 'string', 'max:225'],
                'email'=> ['required', 'string', 'email', 'max:225', 'unique:users'],
                'password' => $this->passwordRules()
            ]);

            if($validator->fails()){
            return ResponseFormatter::error([
                'message' => 'Pastikan email dan password terisi dengan benar', 
                'error' => $validator->errors()
            ], 'Authantication Failed', 400);
            };
            

            //pembuatan user akun
            User::create([
                'name'=> $request->name,
                'no_wa'=> $request->no_wa,
                'email'=> $request->email,
                'password' => Hash::make($request->password)
            ]);

            //cek, ambil data yang sudah tersimpan
            $user = User::where('email', $request->email)->first();
            //ambil token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            //kembalikan token beserta data user
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ]);

        } catch(Exception $error){
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error
            ], 'Authantication Failed', 400);
        }
    }

    public function logout(Request $request){
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request){
        return ResponseFormatter::success($request->user(), 'Data berhasil diambil');
    }

    public function updateProfile(Request $request){
        //buat variabel data untuk menyimpan semua request
        $data = $request->all();
        
        //pastikan user yang login saat ini
        $user = Auth::user();

        //jalankan update data dari variabel data
        $user->update($data);

        //jalankan pesan sukses
        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function updatePhoto(Request $request){
       
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error'=>$validator->errors()], 'Update Photo Fails', 401);
        }

        if ($request->file('file')) {

            $file = $request->file->store('assets/user', 'public');

            //store your file into database
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([$file],'File successfully uploaded');
        }
    }
}