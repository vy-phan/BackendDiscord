<?php

namespace App\Services;

use App\Models\User; // Cần thiết để type-hint $user
use Illuminate\Support\Facades\Auth;


class AuthService
{
    /**
     * Xử lý đăng nhập người dùng.
     *
     * @param array $credentials
     * @return array|null Trả về mảng chứa user và token nếu thành công, null nếu thất bại.
     */
    public function login(array $credentials): ?array
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Lấy người dùng đã được xác thực
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token,
            ];
        }
        return null;
    }

    /**
     * Xử lý đăng xuất người dùng.
     *
     * @param User $user Người dùng cần đăng xuất (đã được xác thực)
     * @return bool
     */
    public function logout(User $user): bool
    {
        try {
            if ($user->currentAccessToken()) {
                $user->currentAccessToken()->delete();
                return true; // Trả về true ngay sau khi xóa token thành công
            } else {
                // Nếu không có current token, có thể coi như đã logout hoặc token đã bị xóa.
                // Hoặc nếu bạn muốn chặt chẽ, có thể xóa tất cả token của user:
                // $user->tokens()->delete();
                return true; // Hoặc false tùy theo logic bạn muốn
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}