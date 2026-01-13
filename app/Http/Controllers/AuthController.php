<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    private const ALLOWED_ROLES = ['staff', 'admin'];

    /**
     * Show the login form.
     */
    public function create(): View
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Authenticate an existing staff/admin user.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
        }

        $user = Auth::user();

        if (!$user->hasRole(self::ALLOWED_ROLES)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Akses ditolak. Hanya staff atau admin yang dapat masuk ke sistem.',
            ]);
        }

        $request->session()->regenerate();

        $intendedUrl = $request->session()->pull('url.intended', $this->getRedirectUrl($user));

        return redirect()->to($intendedUrl)->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userName = Auth::user()->name ?? 'Pengguna';

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar. Sampai jumpa, ' . $userName . '!');
    }

    /**
     * Get redirect URL based on user role.
     */
    private function getRedirectUrl($user): string
    {
        if ($user->canAccessCamera()) {
            return route('dashboard');
        }

        return route('login');
    }
}