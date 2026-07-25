<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        if ($request->banned === 'yes') {
            $query->where('is_banned', true);
        } elseif ($request->banned === 'no') {
            $query->where('is_banned', false);
        }

        $users = $query->withCount('transactions')->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleBan(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak bisa ban admin');
        }

        $user->update([
            'is_banned' => !$user->is_banned,
            'banned_at' => $user->is_banned ? null : now(),
        ]);

        $status = $user->is_banned ? 'di-ban' : 'di-unban';
        return redirect()->route('admin.users.index')->with('success', "User berhasil {$status}");
    }
}
