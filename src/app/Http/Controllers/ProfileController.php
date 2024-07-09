<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stripe\Stripe;
use Stripe\Customer;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        Log::info('Profile update request received', ['user_id' => $user->id, 'request' => $request->all()]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');

            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $path;
            Log::info('Profile image updated', ['path' => $path]);
        }

        $user->name = $request->name ?: $user->email;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;

        $user->save();
        Log::info('User profile updated', ['user' => $user]);

        return redirect()->route('home')->with('success', 'プロフィールが更新されました。');
    }
}
