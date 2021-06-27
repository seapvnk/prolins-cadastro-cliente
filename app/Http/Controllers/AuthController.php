<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


use App\Models\User;
use App\Models\Profile;
use App\Models\Costumer;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'register']]);
    }

    /**
     * Register a costumer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'address' => 'required|min:5|max:255',
            'number' => 'required|min:1|max:7',
            'complement' => 'min:1|max:255',
            'zip' => 'required|min:1|max:255',
            'district' => 'required|min:1|max:255',
            'city' => 'required|min:1|max:255',
            'state' => 'required|max:2',
        ]);

        if($validator->fails())
        {
            $messages = [];
            
            foreach ($validator->errors()->getMessages() as $item) {
                array_push($messages, $item);
            }
            
            return response($messages[0], 400);
        }

        $user = new User([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        try {
            $userProfile = Profile::create([
                "description" => "cliente",
                "role" => 2,
            ]);
    
            $user->attachItsProfile($userProfile);
            $user->save();
            
            $costumerData = Costumer::make([
                "name" => $request->name,
                "email" => $request->email,
                "address" => $request->address,
                "number" => $request->number,
                "complement" => $request->complement,
                "zip" => $request->zip,
                "district" => $request->district,
                "city" => $request->city,
                "state" => $request->state,
            ]);

            $costumerData->attachItsUser($user);
            $costumerData->save();

        } catch (\Illuminate\Database\QueryException $e) {
            $user->delete();

            return response([
                'status' => 'error',
                'error' => $e
            ], 500);
        }

        return response([
            'status' => 'ok',
            'user' => $user,
        ], 201);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    
}