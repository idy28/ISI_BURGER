<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'username' => 'required|string',
        ], [
            'password.required' => 'Veuillez saisir le mot de passe.',
            'username.required' => 'Veuillez saisir le nom d\'utilisateur.',
        ]);

        if ($request->password === env('APP_ADMIN_PASSWORD', 'admin123') && $request->username === env('APP_ADMIN_USERNAME', 'admin')) {
            session(['admin_logged_in' => true]);
            session(['admin_login_at' => now()]);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Bienvenue dans l’espace administrateur!');
        }

        return back()->withErrors(['password' => 'Identifiant ou mot de passe incorrect. Veuillez réessayer.']);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_login_at']);
        return redirect()->route('admin.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}