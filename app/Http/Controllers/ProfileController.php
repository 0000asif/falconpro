<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', compact('user'));
    }


    public function edit()
    {
        $user               = auth()->user();
        $role_permissions   = Role::with('permissions')->get();

        return view('profile.edit', compact('user', 'role_permissions'));
    }

    public function update(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'old_password' => 'required|string|min:6',  // Validate the old password
            'password' => 'nullable|confirmed|min:6',  // Password validation
        ]);

        $user = auth()->user();  // Get the authenticated user
        // dd($validatedData['old_password']);
        if (!Hash::check($validatedData['old_password'], $user->password)) {
            return back()->with('failed', 'Old password does not match');
        }
        $user->name = $validatedData['name'];  // Update the name
        $user->email = $validatedData['email'];  // Update the email

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save(); // Save the changes to the database
        $user->assignRole($request->user_role);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
}
