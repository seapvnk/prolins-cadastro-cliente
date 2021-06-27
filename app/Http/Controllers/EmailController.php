<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;


class EmailController extends Controller
{
    public function reset(Request $request, $email)
    {

        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $user = User::where("email", $email)->first();

        $newPassword = Str::random(8);
        $user->password = bcrypt($newPassword);
        $user->save();

        $title = "Recuperação de senha - Cadastro de clientes";

        $content = "Sua senha agora é: ". $newPassword ;

        Mail::send('forgot-password', ['title' => $title, 'content' => $content], function ($message) use ($request)
        {
            $message->from('www.psro@gmail.com', 'Cadastro de clientes');
            $message->to($request->email);
        });


        return response()->json(['message' => 'E-Mail sent!']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->json()->all(), ['email' => 'required|email']);
        
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

        $title = "Recuperação de senha - Cadastro de clientes";

        if (!$user = User::where("email", $request->email)->first()) {
            return response([
                'status' => 'error',
                'errors' => ['E-Mail não encontrado!'],
            ], 404);
        }

        $title = "Recuperação de senha - Cadastro de clientes";

        $url = URL::temporarySignedRoute(
            'reset', now()->addMinutes(30), ['email' => $user->email]
        );
        $content = "Clique aqui para resetar sua senha: ";

        Mail::send('forgot-password', ['title' => $title, 'content' => $content, 'url' => $url], function ($message) use ($request)
        {
            $message->from('www.psro@gmail.com', 'Cadastro de clientes');
            $message->to($request->email);
        });

        return response()->json(['message' => 'E-Mail sent!']);
    }
}
