<?php

namespace App\Services;

use App\Core\ServiceReturn;
use App\Models\User;

class AuthService
{
    public function __construct(
        protected User $userModel
    )
    {
    }

    public function handleLoginUser($credentials): ServiceReturn
    {
        $phone = $credentials['phone'];
        $password = $credentials['password'];
        $user =  $this->userModel->where('phone', $phone)->first();
        if(!$user) {
            return ServiceReturn::error('Số điện thoại không tồn tại', null, null, 404);
        }
        // Thực hiện xác thực người dùng dựa trên số điện thoại và mật khẩu
        if (auth()->attempt(['phone' => $phone, 'password' => $password])) {
            // Xác thực thành công
            return ServiceReturn::success([
                'message' => 'Đăng nhập thành công',
                'user' => auth()->user(),
            ]);
        }

        // Xác thực thất bại
        return ServiceReturn::error('Số điện thoại hoặc mật khẩu không đúng', null, null, 401);
    }
}
