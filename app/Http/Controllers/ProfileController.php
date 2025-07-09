<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show'); 
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);
        $user = Auth::user();

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('profile.edit')->with('success', 'Informations mises à jour.');
    }
    public function passwordForm()
{
    return view('profile.password');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    if (!\Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
    }

    Auth::user()->update([
        'password' => bcrypt($request->new_password),
    ]);

    return back()->with('success', 'Mot de passe modifié avec succès.');
 }
}
