<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;

class ProfileController extends Controller
{
	public function getAuthUser ()
	{
		return Auth::user();
	}

	public function updateAuthUser (Request $request)
	{
		$this->validate($request, [
			'name' => 'required|string',
			'email' => 'required|email|unique:users,email,'.Auth::id()
		]);

		$user = User::find(Auth::id());

		$user->name = $request->name;
		$user->email = $request->email;
		$user->save();

		return $user;
	}

	public function updateAuthUserPassword(Request $request)
    {
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }
}
