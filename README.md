<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Trạng thái Build"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Tổng lượt tải"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Phiên bản ổn định mới nhất"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="Giấy phép"></a>
</p>

# Discord Clone - Backend API

Copy y chang Discord phiên bản Sộp pe

## 🛠 Công nghệ sử dụng
- PHP 8.1+
- Laravel 10
- Laravel Sanctum (Xác thực API)
- MySQL (Cơ sở dữ liệu)
- Thiết kế RESTful 
(  dự kiến )
- Breeze + Socialite cho xác thực và đăng nhập bên thứ 3 (Google, Github)
- Realtime : beyondcode/laravel-websockets

## 📂 Cấu trúc dự án

app/
├── Console/              # Lệnh Artisan (Lớp Infrastructure)
├── Exceptions/           # Ngoại lệ tùy chỉnh (Lớp Cross-cutting ) : xử lí lỗi của ứng dụng
├── Http/
│   ├── Controllers/      # Bộ điều khiển API (Lớp Presentation)
│   ├── Middleware/       # Middleware tùy chỉnh (Lớp Presentation)
├── Models/               # Model Eloquent (Lớp Domain) : định nghĩa các Table
├── Providers/            # Lớp Infrastructure :  Trung gian kết nối Repositories và Services
└── Repositories/         # Lớp Persistence
    └── Interfaces/       # Định nghĩa tham số đầu vào cho hàm (Lớp Application)

bootstrap/               # Khởi tạo framework ( kệ cha không quan tâm vì lavarel đang là backend)
config/                  # File cấu hình
database/
├── factories/           # Factory model
├── migrations/          # Di chuyển cơ sở dữ liệu
└── seeders/             # Dữ liệu mẫu

public/                  # Tài nguyên công khai ( kệ cha)
resources/               # Tài nguyên (kệ cha)

routes/
├── api.php              # Route API ( cần quan tâm , sẽ làm việc thường xuyên )
├── channels.php         # Kênh broadcast
├── console.php          # Route console
└── web.php              # Route web ( kệ cha )

storage/                 # Lưu trữ log, cache, v.v.
tests/                   # Kiểm thử PHPUnit

## Bắt đầu
1. Cài đặt dependencies:
```bash
composer install
```
2. Sao chép .env.example to .env và  cấu hình database của bạn:
```bash
copy .env.example .env
```
3. Tạo application key:
```bash
php artisan key:generate
```
4. Lệnh migrations:
```bash
php artisan migrate
php artisan db:seed
```
5. Start development server:
```bash
php artisan serve
```

## Tài liệu API
Các endpoint API được định nghĩa trong routes/api.php và tuân theo quy ước RESTful.

## Giấy phép
Dự án này sử dụng giấy phép mã nguồn mở MIT.

Phiên bản này:
1. Đã loại bỏ nội dung mặc định của Laravel
2. Tập trung vào cấu trúc backend Discord Clone
3. Chỉ bao gồm các phần cần thiết
4. Cung cấp hướng dẫn cài đặt rõ ràng
5. Duy trì thông báo giấy phép MIT
