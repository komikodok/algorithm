<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|string|min:8|confirmed',
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
            return response()->json(['message' => 'User created successfully'], 201);
        } catch (\Exception $e) {
            Log::info('Database message: ' . $e);
            return response()->json(['message' => 'Failed to created user', 'error' => $e->getMessage()], 500);
        }
    }

    public function getUsersData(Request $request)
    {
        $users = User::select('id', 'email', 'name', 'avatar');
        return DataTables::of($users)
            ->addColumn('avatar', function($user) {
                return '<img src="' . asset('uploads/' . $user->avatar) . '" width="200" height="200">';
            })
            ->rawColumns(['avatar'])
            ->make(true);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users')->with([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        try {
            $user->delete();

            return redirect()->route('users')->with([
                'status' => 'success',
                'message' => 'User deleted successfully',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('users')->with([
                'status' => 'error',
                'message' => 'Failed to delete user',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $user->name = $validatedData['name'];
    
        if ($request->has('password')) {
            $user->password = bcrypt($validatedData['password']);
        }
    
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
    
        $user->save();
    
        return redirect()->route('user.profile', $user->id)->with('success', 'User updated successfully.');
    }
}
