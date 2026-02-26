<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Foncton pour la page register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Fonction pour afficher la page login
    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role'] = 'client';
        $validatedData['isAuth'] = true;
        $user = User::create($validatedData);

        if (! $user) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du compte.');
        }

        return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès ! Veuillez vous connecter.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    // Fonction pour le logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
