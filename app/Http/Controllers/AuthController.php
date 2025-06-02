<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Inject AuthService vào constructor.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Xử lý đăng nhập người dùng.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // Validate input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ], [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không hợp lệ.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            ]);

            // Gọi service để xử lý đăng nhập
            $result = $this->authService->login($credentials, $request);

            if ($result) {
                return $result; // Trả về response đã chứa cookie từ AuthService
            }

            return response()->json([
                'message' => 'Thông tin đăng nhập không đúng. Vui lòng kiểm tra email hoặc mật khẩu.',
                'errors' => [
                    'email' => ['Email hoặc mật khẩu không chính xác.'],
                    'password' => ['Email hoặc mật khẩu không chính xác.'],
                ],
            ], 401);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi đăng nhập. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    /**
     * Xử lý đăng xuất người dùng.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user(); // Lấy user đã được xác thực bởi middleware auth:sanctum

            if (!$user) {
                return response()->json([
                    'message' => 'Không tìm thấy người dùng hoặc token không hợp lệ.',
                ], 401);
            }

            if ($this->authService->logout($user, $request)) {
                return response()->json([
                    'message' => 'Đăng xuất thành công',
                ], 200);
            }

            return response()->json([
                'message' => 'Đăng xuất thất bại. Vui lòng thử lại.',
            ], 500);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi đăng xuất. Vui lòng thử lại sau.',
            ], 500);
        }
    }
}