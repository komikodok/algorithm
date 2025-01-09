<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        try {
            $request->image->move(public_path('uploads'), $imageName);
            User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'avatar' => $imageName,
            ]);
            return response()->json(['message' => 'User created successfully!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat pengguna', 'error' => $e->getMessage()], 500);
        }
    }

    public function getUsersData(Request $request)
    {
        $users = User::select('id', 'email', 'name', 'avatar')->get();

        if ($request->ajax()) {
            return DataTables::of($users)
                ->addColumn('avatar', function($user) {
                    return '<img src="' . asset('uploads/' . $user->avatar) . '" width="200" height="200">';
                })
                ->rawColumns(['avatar'])
                ->make(true);
        }
    }
}
