<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(10);
        return view('superadmin.users', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = [
            'supplier' => 'Supplier',
            'dropshipper' => 'Dropshipper',
            'super_admin' => 'Super Admin',
            'admin_produk' => 'Admin Produk',
            'admin_pengguna' => 'Admin Pengguna',
            'admin_transaksi' => 'Admin Transaksi',
            'admin_laporan' => 'Admin Laporan',
        ];
        
        return view('superadmin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:supplier,dropshipper,super_admin,admin_produk,admin_pengguna,admin_transaksi,admin_laporan'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->has('is_active') ? true : false,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('superadmin.users')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        $roles = [
            'supplier' => 'Supplier',
            'dropshipper' => 'Dropshipper',
            'super_admin' => 'Super Admin',
            'admin_produk' => 'Admin Produk',
            'admin_pengguna' => 'Admin Pengguna',
            'admin_transaksi' => 'Admin Transaksi',
            'admin_laporan' => 'Admin Laporan',
        ];
        
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:supplier,dropshipper,super_admin,admin_produk,admin_pengguna,admin_transaksi,admin_laporan'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('superadmin.users')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting super admin
        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.users')
                ->with('error', 'Tidak dapat menghapus Super Admin.');
        }
        
        $user->delete();

        return redirect()->route('superadmin.users')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}

