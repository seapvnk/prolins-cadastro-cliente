<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Profile;
use App\Models\Costumer;

class DashboardController extends Controller
{

    /**
     * return the basic dashboard info.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $usersQuery = "SELECT users.*, role FROM users JOIN profiles ON `users`.profile_id = `profiles`.id WHERE profiles.role = 1";

        $user = auth('api')->user();
        $user->profile = $user->profile();
        $users = array_map(function ($u) {
            unset($u->password);
            return $u;
        }, DB::select($usersQuery));

        if ($user->profile()->role == 1)
        {
            return response([
                "user" => $user,
                "users" => $users,
                "costumers" => Costumer::all()
            ]);

        }
        else
        {
            return response([
                "user" => $user->toArray(),
                "costumer_data" => Costumer::where("user_id", $user->id)->first()
            ]);
        }


    }

    /**
     * Create an user.
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'description' => 'max:255',
        ]);

        
        if($validator->fails())
        {
            $messages = [];
            
            foreach ($validator->errors()->getMessages() as $item) {
                array_push($messages, $item);
            }
            
            return response([
                'status' => 'error',
                'errors' => $messages,
            ], 400);
        }

        $user = new User([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        $userProfile = Profile::create([
            "description" => $request->description,
            "role" => 1,
        ]);

        $user->attachItsProfile($userProfile);
        $user->save();

        return response([
            'status' => 'ok',
            'user' => $user,
        ], 201);
    }

}
