<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->tokens->count() > 0) {
            $token = $user->tokens()->delete();
        }

        $token = $user->createToken('flashcardpro')->plainTextToken;

        return view('profile', ['token' => $token]);
    }
}
