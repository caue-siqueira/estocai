<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->remember)) {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'funcionario'])) {
            return redirect()->intended('/painel');
        } else {
            Auth::logout();
            return back()->withErrors(['email' => 'Usuário sem função válida.']);
        }
    }

    return back()->withErrors(['email' => 'Credenciais inválidas.']);
}


}