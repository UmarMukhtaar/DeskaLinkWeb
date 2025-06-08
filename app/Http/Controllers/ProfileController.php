<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            // Handle profile photo upload to Cloudinary
            if ($request->hasFile('profile_photo')) {
                $uploadedFile = $request->file('profile_photo');
                $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'profile_image',
                    'public_id' => 'user_' . $user->id,
                    'transformation' => [
                        'width' => 200,
                        'height' => 200,
                        'crop' => 'fill',
                        'gravity' => 'face'
                    ]
                ]);
                
                $data['profile_photo_url'] = $result->getSecurePath();
            }

            // Fill user data
            $user->fill($data);

            // No need for email verification, so we can remove this part
            // if ($user->isDirty('email')) {
            //     $user->email_verified_at = null;
            // }

            $user->save();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        try {
            $request->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('status', 'password-updated');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupdate password: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);

            $user = $request->user();

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('success', 'Akun berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }
}