<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    /**
     * Apply middleware to restrict access
     */
    public function __construct()
    {
        // Staff dan admin bisa lihat list
        $this->middleware(['auth', 'role:staff,admin'])->only(['index']);
        
        // Hanya admin yang bisa create, edit, delete
        $this->middleware(['auth', 'role:admin'])->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of staff.
     */
    public function index(Request $request): View
    {
        $query = User::whereIn('role', ['staff', 'admin'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan role jika ada
        if ($request->has('role') && in_array($request->role, ['staff', 'admin'])) {
            $query->where('role', $request->role);
        }

        // Search berdasarkan nama atau email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $staff = $query->paginate(10);

        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create(): View
    {
        return view('staff.create');
    }

    /**
     * Store a newly created staff in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role' => ['required', Rule::in(['staff', 'admin'])],
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role harus dipilih.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified staff.
     */
    public function edit(User $staff): View
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff in storage.
     */
    public function update(Request $request, User $staff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'password' => ['nullable', 'confirmed', Password::min(6)],
            'role' => ['required', Rule::in(['staff', 'admin'])],
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role harus dipilih.',
        ]);

        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        $staff->role = $validated['role'];

        // Update password hanya jika diisi
        if (!empty($validated['password'])) {
            $staff->password = Hash::make($validated['password']);
        }

        $staff->save();

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil diperbarui.');
    }

    /**
     * Remove the specified staff from storage.
     */
    public function destroy(User $staff): RedirectResponse
    {
        // Cegah admin menghapus dirinya sendiri
        if ($staff->id === Auth::id()) {
            return redirect()->route('staff.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil dihapus.');
    }
}