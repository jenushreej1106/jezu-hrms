<?php

namespace App\Filament\Widgets;

use App\Models\Payroll;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentPayrolls extends TableWidget
{
    protected static ?string $heading = 'Recent Payrolls';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payroll::query()
                    ->with('employee')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('salary_month')
                    ->label('Salary Month')
                    ->sortable(),

                Tables\Columns\TextColumn::make('basic_salary')
                    ->label('Basic Salary')
                    ->money('INR'),

                Tables\Columns\TextColumn::make('allowances')
                    ->label('Allowances')
                    ->money('INR'),

                Tables\Columns\TextColumn::make('deductions')
                    ->label('Deductions')
                    ->money('INR'),

                Tables\Columns\TextColumn::make('net_salary')
                    ->label('Net Salary')
                    ->money('INR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
