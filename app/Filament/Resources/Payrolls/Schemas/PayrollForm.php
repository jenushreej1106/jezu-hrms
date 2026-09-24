<?php

namespace App\Filament\Resources\Payrolls\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PayrollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->label('Employee')
                    ->options(
                        Employee::query()
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->required(),

                TextInput::make('salary_month')
                    ->label('Salary Month')
                    ->placeholder('September 2026')
                    ->required(),

                TextInput::make('basic_salary')
                    ->label('Basic Salary')
                    ->numeric()
                    ->prefix('?')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $basic = (float) ($get('basic_salary') ?? 0);
                        $allowances = (float) ($get('allowances') ?? 0);
                        $deductions = (float) ($get('deductions') ?? 0);

                        $set(
                            'net_salary',
                            $basic + $allowances - $deductions
                        );
                    }),

                TextInput::make('allowances')
                    ->label('Allowances')
                    ->numeric()
                    ->prefix('?')
                    ->default(0)
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $basic = (float) ($get('basic_salary') ?? 0);
                        $allowances = (float) ($get('allowances') ?? 0);
                        $deductions = (float) ($get('deductions') ?? 0);

                        $set(
                            'net_salary',
                            $basic + $allowances - $deductions
                        );
                    }),

                TextInput::make('deductions')
                    ->label('Deductions')
                    ->numeric()
                    ->prefix('?')
                    ->default(0)
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $basic = (float) ($get('basic_salary') ?? 0);
                        $allowances = (float) ($get('allowances') ?? 0);
                        $deductions = (float) ($get('deductions') ?? 0);

                        $set(
                            'net_salary',
                            $basic + $allowances - $deductions
                        );
                    }),

                TextInput::make('net_salary')
                    ->label('Net Salary')
                    ->numeric()
                    ->prefix('?')
                    ->required()
                    ->readOnly(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Paid' => 'Paid',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->default('Pending')
                    ->required(),
            ]);
    }
}
