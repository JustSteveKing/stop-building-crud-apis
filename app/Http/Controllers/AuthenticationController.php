<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticationController
{
    public function login(LoginRequest $request): Response
    {
        /** @var User $user */
        $user = User::query()->where(
            column: 'email',
            value: $request->string('email')->toString(),
        )->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (! Hash::check(
            value: $request->string('password')->toString(),
            hashedValue: $user->password,
        )) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken(
            name: 'auth_token',
            abilities: ['*'],
        );

        return new JsonResponse(
            data: [
                'token' => $token->plainTextToken,
            ],
        );
    }
}
