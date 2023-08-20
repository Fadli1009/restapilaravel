<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\throwException;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['data tidak tersedia.'],
            ]);
        }
        return $user->createToken('login user')->plainTextToken;
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }

}