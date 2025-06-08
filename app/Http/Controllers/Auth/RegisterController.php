<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * Akan diabaikan karena kita override method redirectTo()
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Tampilkan form register (optional jika pakai default)
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Validasi input saat pendaftaran
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:client,partner'],
        ]);
    }

    /**
     * Buat user baru setelah validasi berhasil
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        event(new Registered($user));
        return $user;
    }

    /**
     * Override metode redirectTo untuk mengarahkan sesuai role
     */
    protected function redirectTo()
    {
        return match (auth()->user()->role) {
            'admin' => route('admin.dashboard'),
            'partner' => route('partner.dashboard'),
            default => route('client.market'),
        };
    }
}
