<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Cookie;

class AuthService
{
    /**
     * Xử lý đăng nhập người dùng và trả về token cùng cookie.
     *
     * @param array $credentials
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(array $credentials, Request $request)
    {
        try {
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Thông tin đăng nhập không đúng.',
                ], 401);
            }

            $user = Auth::user();
            $accessToken = $user->createToken('auth_token')->plainTextToken;
            $refreshToken = $user->createToken('refresh_token')->plainTextToken;

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ], 200)->withCookie('access_token', $accessToken, 60, '/', null, true, true, false, 'lax')
                ->withCookie('refresh_token', $refreshToken, 7 * 24 * 60, '/', null, true, true, false, 'lax');
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi đăng nhập.',
            ], 500);
        }
    }

    /**
     * Xử lý đăng xuất người dùng và xóa cookie.
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(User $user, Request $request)
    {
        try {
            $user->tokens()->delete();

            $response = response()->json([
                'message' => 'Đăng xuất thành công',
            ], 200);

            // Xóa cookie access_token và refresh_token
            return $response->withCookie('access_token', '', -1, '/', null, true, true, false, 'lax')
                ->withCookie('refresh_token', '', -1, '/', null, true, true, false, 'lax');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Đăng xuất thất bại.',
            ], 500);
        }
    }
}