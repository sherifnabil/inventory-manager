<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiHelper::failApiResponse(
                msg: 'Invalid credentials',
                statusCode: Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $user->createToken('inventory-manager')->plainTextToken;

        return ApiHelper::apiResponse([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiHelper::apiResponse(
            data: ['message' => 'Logged out successfully'],
            statusCode: Response::HTTP_OK
        );
    }
}
