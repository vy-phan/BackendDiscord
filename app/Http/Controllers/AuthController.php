<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Đăng nhập bằng email và password, trả về token
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        // Check credentials
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Tạo Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'message' => 'Thông tin đăng nhập không đúng. Vui lòng kiểm tra email hoặc mật khẩu.',
            'errors' => [
                'email' => ['Email hoặc mật khẩu không chính xác.'],
                'password' => ['Email hoặc mật khẩu không chính xác.'],
            ],
        ], 401);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!$request->user()) {
            return response()->json([
                'message' => 'Không tìm thấy người dùng hoặc token không hợp lệ.',
            ], 401);
        }

        try {
            // Xóa token hiện tại khỏi cơ sở dữ liệu (Sanctum)
            $request->user()->currentAccessToken()->delete();

            // Xóa toàn bộ session (nếu có)
            $request->session()->flush();

            // Đăng xuất người dùng khỏi Auth (xóa trạng thái đăng nhập)
            Auth::logout();

            return response()->json([
                'message' => 'Đăng xuất thành công',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đăng xuất thất bại. Vui lòng thử lại.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}