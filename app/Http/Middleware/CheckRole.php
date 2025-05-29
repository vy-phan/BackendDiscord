<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Lấy vai trò của người dùng
        $userRole = Auth::user()->role; 

        // Kiểm tra nếu vai trò của người dùng có trong danh sách vai trò được phép
        if (!in_array($userRole, $roles)) {
            return redirect('/welcome'); // Chuyển hướng nếu không đủ quyền
        }

        return $next($request);
    }
}