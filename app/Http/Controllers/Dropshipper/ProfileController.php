<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get order statistics
        $totalOrders = \App\Models\Order::where('user_id', $user->id)->count();
        $totalSpent = \App\Models\Order::where('user_id', $user->id)
            ->where('payment_status', 'sudah_dibayar')
            ->sum('total');
        $totalProducts = \App\Models\Order::where('user_id', $user->id)
            ->whereHas('items')
            ->with('items')
            ->get()
            ->sum(function($order) {
                return $order->items->sum('quantity');
            });
        
        return view('dropshipper.profile', compact('user', 'totalOrders', 'totalSpent', 'totalProducts'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
