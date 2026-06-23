<?php

namespace App\Services;

use App\Core\ServiceReturn;
use App\Models\User;
use Filament\Facades\Filament;

class AuthService
{
    public function __construct(
        protected User $userModel
    ) {
    }

    public function handleLoginUser(array $credentials): ServiceReturn
    {
        $phone = $credentials['phone'];
        $password = $credentials['password'];

        $user = $this->userModel->where('phone', $phone)->first();

        if (! $user) {
            return ServiceReturn::error('Số điện thoại không tồn tại', null, null, 404);
        }

        if (! $user->isAdmin()) {
            return ServiceReturn::error('Bạn không có quyền truy cập', null, null, 403);
        }

        if (! $user->isActive()) {
            return ServiceReturn::error('Tài khoản quản trị hiện đang bị khóa hoặc ngừng hoạt động', null, null, 403);
        }

        if (Filament::auth()->attempt([
            'phone' => $phone,
            'password' => $password,
        ])) {
            return ServiceReturn::success([
                'message' => 'Đăng nhập thành công',
                'user' => Filament::auth()->user(),
            ]);
        }

        return ServiceReturn::error('Số điện thoại hoặc mật khẩu không đúng', null, null, 401);
    }
}
