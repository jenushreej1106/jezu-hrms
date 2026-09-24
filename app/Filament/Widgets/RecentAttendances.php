<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentAttendances extends TableWidget
{
    protected static ?string $heading = 'Recent Attendance';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Attendance::query()
                    ->with('employee')
                    ->latest('attendance_date')
                    ->latest('created_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable(),

                Tables\Columns\TextColumn::make('attendance_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('check_in')
                    ->label('Check In'),

                Tables\Columns\TextColumn::make('check_out')
                    ->label('Check Out'),
            ])
            ->paginated(false);
    }
}
