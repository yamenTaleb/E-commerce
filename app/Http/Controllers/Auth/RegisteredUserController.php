<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\UserDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, UserDTO $userDTO)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $userDTO = UserDTO::fromRequest($request);

        $user = User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'address' => $userDTO->address,
            'phone' => $userDTO->phone,
            'password' => Hash::make($userDTO->string('password')),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::sendResponse(201, 'user registered', [
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }
}
