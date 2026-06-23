<?php

namespace App\Filament\Pages;

use App\Services\AuthService;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\LoginResponse;
use Filament\Auth\Pages\Login as PagesLogin;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;
use Throwable;

class Login extends PagesLogin
{
    protected AuthService $authService;

    public function boot(AuthService $authService): void
    {
        $this->authService = $authService;
    }

    public function getView(): string
    {
        return 'filament.pages.login';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('phone')
                ->label('Số điện thoại')
                ->string()
                ->required()
                ->autocomplete('phone')
                ->extraInputAttributes([
                    'tabindex' => 1,
                    'required' => false,
                ])
                ->validationMessages([
                    'required' => 'Số điện thoại không được để trống',
                ]),
            TextInput::make('password')
                ->label('Mật khẩu')
                ->password()
                ->revealable(filament()->arePasswordsRevealable())
                ->autocomplete('current-password')
                ->required()
                ->extraInputAttributes([
                    'tabindex' => 2,
                    'required' => false,
                ])
                ->validationMessages([
                    'required' => 'Mật khẩu không được để trống',
                ]),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::auth/pages/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => $exception->minutesUntilAvailable,
                ]))
                ->body(array_key_exists('body', __('filament-panels::auth/pages/login.notifications.throttled') ?: []) ? __('filament-panels::auth/pages/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => $exception->minutesUntilAvailable,
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $result = $this->authService->handleLoginUser([
            'phone' => $data['phone'],
            'password' => $data['password'],
        ]);

        if ($result->isError()) {
            if ($result->getException() instanceof Throwable) {
                throw $result->getException();
            }

            throw ValidationException::withMessages([
                'data.phone' => $result->getMessage(),
            ]);
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
