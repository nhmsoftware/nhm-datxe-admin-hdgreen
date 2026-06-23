<?php

namespace App\Filament\Clusters\DriverFinance\Pages;

use App\Filament\Clusters\DriverFinance\DriverFinanceCluster;
use App\Models\Finance\CreditWalletConfig;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Validation\ValidationException;

class ManageCreditWalletConfig extends Page
{
    protected string $view = 'filament.clusters.driver-finance.pages.manage-credit-wallet-config';

    protected static ?string $cluster = DriverFinanceCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedWallet;

    protected static ?string $navigationLabel = 'Credit Wallet';

    protected static ?string $slug = 'credit-wallet-config';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return 'Cấu hình tín dụng';
    }

    public static function getModelLabel(): string
    {
        return 'Cấu hình tín dụng';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cấu hình tín dụng';
    }

    public function mount(): void
    {
        $config = CreditWalletConfig::query()->firstOrCreate([], [
            'min_balance' => 50000,
            'auto_lock' => true,
            'commission_rule' => 'Default rule',
            'updated_by' => auth()->id(),
        ]);

        $this->form->fill([
            'min_balance' => (float) $config->min_balance,
            'auto_lock' => (bool) $config->auto_lock,
            'commission_rule' => $config->commission_rule,
        ]);
    }

    public function getTitle(): string
    {
        return 'Cấu hình Credit Wallet';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Cấu hình ví tín dụng')
                    ->description('Áp dụng cho tài xế đối tác. Tài xế đội xe nhà sẽ bỏ qua credit check.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('min_balance')
                                ->label('Số dư tối thiểu')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->suffix('VND')
                                ->validationMessages([
                                    'required' => 'Không được để trống',
                                    'numeric' => 'Phải là số',
                                    'min' => 'Phải lớn hơn không',
                                ]),
                            Toggle::make('auto_lock')
                                ->label('Tự động khóa nhận cuốc khi số dư thấp')
                                ->default(true),
                            Textarea::make('commission_rule')
                                ->label('Quy tắc khấu trừ hoa hồng')
                                ->rows(4)
                                ->placeholder('Ví dụ: Default rule')
                                ->helperText('Mô tả rule khấu trừ để admin theo dõi; runtime hiện vẫn dùng config ví và logic hệ thống hiện có.')
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        if ((float) ($data['min_balance'] ?? 0) <= 0) {
            throw ValidationException::withMessages([
                'data.min_balance' => 'Minimum Credit Balance không hợp lệ.',
            ]);
        }

        CreditWalletConfig::query()->firstOrCreate([], [
            'min_balance' => 50000,
            'auto_lock' => true,
            'commission_rule' => 'Default rule',
        ])->update([
            'min_balance' => (float) $data['min_balance'],
            'auto_lock' => (bool) ($data['auto_lock'] ?? false),
            'commission_rule' => $data['commission_rule'] ?: 'Default rule',
            'updated_by' => auth()->id(),
        ]);

        Notification::make()
            ->success()
            ->title('Cấu hình Credit Wallet thành công.')
            ->send();
    }
}
