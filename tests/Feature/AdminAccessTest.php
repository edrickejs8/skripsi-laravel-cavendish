<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows admin to access admin-only endpoint', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $token = $admin->createToken('admin-token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/admin-only');

    $response->assertStatus(200)->assertJson([
        'message' => 'Ini halaman dashboard Admin',
    ]);
});

it('denies access to admin-only endpoint for regular user', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $token = $user->createToken('user-token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/admin-only');

    $response->assertStatus(403);
});
