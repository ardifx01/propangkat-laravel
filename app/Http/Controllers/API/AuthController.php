<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user login request via API.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();
            
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;
            
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'user' => $user,
                'token' => $token,
                'role' => $request->get('role')
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Handle user logout request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke all tokens
        $request->user()->tokens()->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);
    }

    /**
     * Get the current authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }
}
