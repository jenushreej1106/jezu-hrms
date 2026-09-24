<?php

namespace App\Filament\Pages;

use App\Models\CompanySetting;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\WithFileUploads;

class CompanySettings extends Page
{
    use WithFileUploads;

    protected string $view = 'filament.pages.company-settings';

    public ?string $company_name = 'Jezu';
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $address = null;
    public ?string $website = null;
    public ?string $logo = null;

    public $logoFile = null;

    public function mount(): void
    {
        $settings = CompanySetting::first();

        if ($settings) {
            $this->company_name = $settings->company_name ?: 'Jezu';
            $this->email = $settings->email;
            $this->phone = $settings->phone;
            $this->address = $settings->address;
            $this->website = $settings->website;
            $this->logo = $settings->logo;
        }
    }

    public function save(): void
    {
        $settings = CompanySetting::firstOrNew(['id' => 1]);

        if ($this->logoFile) {
            $this->logo = $this->logoFile->store(
                'company',
                'public'
            );
        }

        $settings->company_name = $this->company_name ?: 'Jezu';
        $settings->email = $this->email;
        $settings->phone = $this->phone;
        $settings->address = $this->address;
        $settings->website = $this->website;
        $settings->logo = $this->logo;

        $settings->save();

        Notification::make()
            ->title('Company Settings Saved')
            ->success()
            ->send();
    }
}
