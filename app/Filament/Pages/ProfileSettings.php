<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileSettings extends Page
{
    protected string $view = 'filament.pages.profile-settings';

    public string $name = '';
    public string $email = '';

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $user = auth()->user();

        abort_unless($user, 403);

        $this->name = (string) $user->name;
        $this->email = (string) $user->email;
    }

    public function save(): void
    {
        $user = auth()->user();

        abort_unless($user, 403);

        $passwordChanging = filled($this->new_password);

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => [
                Rule::requiredIf($passwordChanging),
                'nullable',
                'current_password:web',
            ],

            'new_password' => [
                'nullable',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user->name = $this->name;
        $user->email = $this->email;

        if ($passwordChanging) {
            $user->password = Hash::make($this->new_password);
        }

        $user->save();

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';

        Notification::make()
            ->title('Profile Updated Successfully')
            ->success()
            ->send();
    }
}
