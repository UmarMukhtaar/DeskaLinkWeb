<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(PasswordUpdateRequest $request): RedirectResponse
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
}