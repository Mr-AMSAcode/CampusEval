<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\InvitationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function show(string $token): View
    {
        $user = User::where('invitation_token', $token)
                    ->whereNull('password')
                    ->where('invitation_token_expires_at', '>', now())
                    ->firstOrFail();

        return view('auth.invitation', ['user' => $user]);
    }

    public function accept(Request $request, string $token): RedirectResponse
    {
        $user = User::where('invitation_token', $token)
                    ->whereNull('password')
                    ->where('invitation_token_expires_at', '>', now())
                    ->firstOrFail();

        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
            'invitation_token' => null,
            'invitation_token_expires_at' => null,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Invitation acceptée. Bienvenue sur CampusEval.');
    }
}
