<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Routing\RedirectController;
use Illuminate\Routing\Redirector;

class AuthController extends Controller
{
    protected $redirect = '/';

    public function signup()
    {
        return view('auth.signup');
    }

    public function signin()
    {
        return view('auth.signin');
    }

    public function registr(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:App\Models\User|email',
            'password' => 'required|min:6'
        ]);

        // $response = [
        //     'name' => request('name'),
        //     'email' => request('email'),
        // ];

        // return response()->json($response);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
        ]);
        $token = $user->createToken('myAppToken')->plainTextToken;

        $user->remember_token = $token;
        $user->save();

        return redirect()->route('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/article');
        } else {
            back()->withErrors(([
                'email' => 'Ошибка входа в аккаунт'
            ]))->onlyInput('email');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
