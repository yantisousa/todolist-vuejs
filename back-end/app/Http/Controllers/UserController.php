<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(Request $request) 
    {
        User::create($request->all());
    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $token = $request->user()->createToken('jwt');
            return response()->json($token->plainTextToken);
        }
    }
    public function logout(Request $request)
    {
       $user = $request->user();
       $user->tokens()->delete();
       return response()->json([], 204);
    }
    public function perfil(Request $request)
    {
        $user = Auth::user();
        dd($user);
        return response()->json($user);
    }
    public function verificacaoUsuarioLogado()
    {
        return response()->json(Auth::check());
    }
}
