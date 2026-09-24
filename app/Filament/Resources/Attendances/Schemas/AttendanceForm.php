<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->label('Employee')
                    ->options(
                        Employee::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('attendance_date')
                    ->label('Attendance Date')
                    ->default(now())
                    ->required(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Present' => 'Present',
                        'Absent' => 'Absent',
                        'Half Day' => 'Half Day',
                        'Leave' => 'Leave',
                    ])
                    ->default('Present')
                    ->required()
                    ->live(),

                TimePicker::make('check_in')
                    ->label('Check In')
                    ->seconds(false),

                TimePicker::make('check_out')
                    ->label('Check Out')
                    ->seconds(false),
            ]);
    }
}
