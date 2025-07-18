<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can register a new user', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201)->assertJsonStructure(['access_token', 'token_type']);
});

it('can login a user and return token', function () {
    $user = User::factory()->create([
        'email' => 'login@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'login@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)->assertJsonStructure(['access_token', 'token_type']);
});

it('can logout authenticated user', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test_token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)->postJson('/api/logout');

    $response->assertStatus(200)->assertJson(['message' => 'Logged Out']);
});

it('can view authenticated user profile', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/user');

    $response->assertStatus(200)->assertJsonFragment([
        'email' => $user->email,
    ]);
});
