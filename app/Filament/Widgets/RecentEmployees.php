<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentEmployees extends TableWidget
{
    protected static ?string $heading = 'Recent Employees';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Employee::query()
                    ->with('department')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->url(
                        fn (Employee $record): string =>
                            route(
                                'filament.admin.resources.employees.edit',
                                ['record' => $record]
                            )
                    ),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone'),

                Tables\Columns\TextColumn::make('job_title')
                    ->label('Job Title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('department.name')
                    ->label('Department'),

                Tables\Columns\TextColumn::make('joining_date')
                    ->label('Joining Date')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('salary')
                    ->label('Salary')
                    ->money('INR')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}