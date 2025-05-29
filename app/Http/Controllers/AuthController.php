<?php

namespace App\Http\Controllers;

use App\Services\AuthService; // Sử dụng AuthService (class cụ thể)
use Illuminate\Http\Request;
// Illuminate\Support\Facades\Auth; // Không cần trực tiếp Auth facade ở đây nữa

class AuthController extends Controller
{
    protected $authService;

    // Inject AuthService
    public function __construct(AuthService $authService) // Type-hint class cụ thể
    {
        $this->authService = $authService;
    }

    /**
     * Đăng nhập bằng email và password, trả về token
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([ // Không cần gán vào biến nếu không dùng lại
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);

        if ($result) {
            return response()->json([
                'message' => 'Đăng nhập thành công',
                'user' => $result['user'],
                'token' => $result['token'],
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
        $user = $request->user(); // Lấy user đã được xác thực bởi middleware auth:sanctum

        if (!$user) {
            // Trường hợp này ít khi xảy ra nếu middleware auth:sanctum được áp dụng đúng và client gửi token hợp lệ.
            return response()->json([
                'message' => 'Không tìm thấy người dùng hoặc token không hợp lệ.',
            ], 401);
        }

        if ($this->authService->logout($user)) {
            // $request->session()->flush(); // Chỉ cần thiết nếu bạn dùng session song song
            return response()->json([
                'message' => 'Đăng xuất thành công',
            ], 200);
        }

        return response()->json([
            'message' => 'Đăng xuất thất bại. Vui lòng thử lại.',
        ], 500);
    }
}