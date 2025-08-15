<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'moblieno'   => 'required|string|max:15',
            'address'    => 'required|string',
            'zipcode'    => 'required|string',
            'city'       => 'required|string',
            'state'      => 'required|string',
            'country'    => 'required|string',
            'role'       => 'in:customer,admin,hotel_owner',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'moblieno'   => $request->moblieno,
            'address'    => $request->address,
            'zipcode'    => $request->zipcode,
            'city'       => $request->city,
            'state'      => $request->state,
            'country'    => $request->country,
            'role'       => $request->role ?? 'customer',
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }


//     public function login(Request $request)
// {
//     $user = User::where('email', request('email'))->first();

//     if ($user == null) {
//         return $this->sendError('First register after Login.', 404);
//     }

//     if (Auth::guard('web')->attempt(['email' => request('email'), 'password' => request('password')])) {
//         $user = Auth::guard('web')->user();

//         if ($user->status == 0 && $user->email_verified_at != null) {
//             return $this->sendError('Invalid login credentials', 404);
//         }

//         $user->save();

//         $user['api_token'] = $user->createToken('HotelBookingSystem')->plainTextToken;


//         $loginResource = new UserResource($user);
//         $message = "User Login suucessfully";

//         return $this->sendDetailsResponse(true, $message, $loginResource);
//     } else {
//         return $this->sendError(__('messages.not_matched'), 404);
//     }
// }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }
}
