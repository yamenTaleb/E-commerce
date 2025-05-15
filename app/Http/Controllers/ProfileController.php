<?php

namespace App\Http\Controllers;

use App\DTOs\UserDTO;
use App\Helpers\ApiResponse;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function update(ProfileUpdateRequest $request, UserDTO $userDTO)
    {
        $userDTO = UserDTO::fromRequest($request);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $imageName = storeImage($userDTO->file('image')?? null, 'users');
        $userDTO->image = $imageName;

        $request->user()->update(array_filter([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'phone' => $userDTO->phone,
            'address' => $userDTO->address,
            'image' => $userDTO->image,
        ]));

        return ApiResponse::sendResponse(200, 'Profile updated successfully.', ['user' => $request->user()]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ApiResponse::sendResponse(204, 'Account deleted successfully', null);
    }
}
