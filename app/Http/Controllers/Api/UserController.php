<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validator= Validator::make($request->all(), [

            'name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required' ,'string', 'email', 'unique:users,email'], 
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/','confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/'],
        ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->messages(),400);
        }
        else
        {
            DB::beginTransaction();
            try {

            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
            DB::commit();
            return response()->json(['message' =>'User successfully signed up!'], 201);
            }
            catch (\Exception $e) {
                  DB::rollBack();
                return response()->json(['message' =>'Internal Server error'],500);
            }
        }   
    }

    public function login(Request $request)
    {
        $validator= Validator::make($request->all(), [

            'email' => ['required' ,'string', 'email'], 
            'password' => ['required', 'string'],  
        ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->messages(),400);
        }

        if (! $token = JWTAuth::attempt($request->only('email', 'password'))) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
