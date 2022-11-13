<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    //
    public function index(Request $request)
    {
        $per_page = abs($request->per_page) > 0 ? abs($request->per_page) : 15;
        $users = User::paginate($per_page)->through(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at
            ];
        });
        return Inertia::render('User/Index')->with(['users' => $users]);
    }

    public function profile()
    {
        return Inertia::render('User/Profile');
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required',  'email'],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        if (isset($request->password))
            $user->password = Hash::make($request->password);

        if ($user->save())
            Redirect::route('admin.users.profile')->with('success', 'اطلاعات کاربری با موفقیت به روز شد.');
        else
            Redirect::route('admin.users.profile')->with('error', 'لطفا اطلاعات را درست وارد کنید');
    }
}
