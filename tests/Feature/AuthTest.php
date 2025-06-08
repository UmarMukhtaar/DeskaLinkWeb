<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('users can register', function () {
    $response = $this->post('/register', [
        'user_id' => 'test123',
        'username' => 'testuser',
        'full_name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/dashboard');
});

test('users can login', function () {
    $user = User::factory()->create([
        'user_id' => 'test123',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect('/dashboard');
});

test('users are redirected to correct dashboard based on role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $partner = User::factory()->create(['role' => 'partner']);
    $client = User::factory()->create(['role' => 'client']);

    $this->actingAs($admin)->get('/dashboard')->assertViewIs('admin.dashboard');
    $this->actingAs($partner)->get('/dashboard')->assertViewIs('partner.dashboard');
    $this->actingAs($client)->get('/dashboard')->assertViewIs('client.market');
});