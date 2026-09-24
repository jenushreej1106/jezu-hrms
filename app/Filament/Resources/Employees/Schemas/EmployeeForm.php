<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Department;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('photo')
                    ->label('Profile Photo')
                    ->image()
                    ->disk('public')
                    ->directory('employees')
                    ->imageEditor()
                    ->maxSize(2048),

                TextInput::make('name')
                    ->label('Employee Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(20),

                TextInput::make('job_title')
                    ->label('Job Title')
                    ->maxLength(255),

                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload(),

                DatePicker::make('joining_date')
                    ->label('Joining Date'),

                TextInput::make('salary')
                    ->numeric()
                    ->prefix('?'),
            ]);
    }
}
