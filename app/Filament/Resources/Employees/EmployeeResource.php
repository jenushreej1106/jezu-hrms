<?php

namespace App\Filament\Resources\Employees;

use App\Filament\Resources\Employees\Pages\CreateEmployee;
use App\Filament\Resources\Employees\Pages\EditEmployee;
use App\Filament\Resources\Employees\Pages\ListEmployees;
use App\Filament\Resources\Employees\Pages\ViewEmployee;
use App\Filament\Resources\Employees\Schemas\EmployeeForm;
use App\Filament\Resources\Employees\Tables\EmployeesTable;
use App\Models\Employee;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationLabel = 'Employees';

    public static function form(Schema $schema): Schema
    {
        return EmployeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Employee Profile')
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('Profile Photo')
                            ->state(fn (Employee $record) =>
                                $record->photo
                                    ? asset('storage/' . $record->photo)
                                    : null
                            )
                            ->circular()
                            ->size(150),

                        TextEntry::make('name')
                            ->label('Employee Name')
                            ->weight('bold'),

                        TextEntry::make('job_title')
                            ->label('Job Title'),

                        TextEntry::make('department.name')
                            ->label('Department'),

                        TextEntry::make('email')
                            ->label('Email'),

                        TextEntry::make('phone')
                            ->label('Phone'),

                        TextEntry::make('joining_date')
                            ->label('Joining Date')
                            ->date('d M Y'),

                        TextEntry::make('salary')
                            ->label('Salary')
                            ->money('INR'),
                    ])
                    ->columns(3),

                Section::make('Leave History')
                    ->schema([
                        RepeatableEntry::make('leaves')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('leave_type')->label('Leave Type'),
                                TextEntry::make('start_date')->label('Start Date')->date('d M Y'),
                                TextEntry::make('end_date')->label('End Date')->date('d M Y'),
                                TextEntry::make('reason')->label('Reason'),
                                TextEntry::make('status')->label('Status')->badge(),
                            ])
                            ->columns(5),
                    ])
                    ->columnSpanFull(),

                Section::make('Attendance History')
                    ->schema([
                        RepeatableEntry::make('attendances')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('attendance_date')->label('Date')->date('d M Y'),
                                TextEntry::make('status')->label('Status')->badge(),
                                TextEntry::make('check_in')->label('Check In'),
                                TextEntry::make('check_out')->label('Check Out'),
                            ])
                            ->columns(4),
                    ])
                    ->columnSpanFull(),

                Section::make('Payroll History')
                    ->schema([
                        RepeatableEntry::make('payrolls')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('salary_month')->label('Salary Month'),
                                TextEntry::make('basic_salary')->label('Basic Salary')->money('INR'),
                                TextEntry::make('allowances')->label('Allowances')->money('INR'),
                                TextEntry::make('deductions')->label('Deductions')->money('INR'),
                                TextEntry::make('net_salary')->label('Net Salary')->money('INR'),
                                TextEntry::make('status')->label('Status')->badge(),
                            ])
                            ->columns(6),
                    ])
                    ->columnSpanFull(),

                Section::make('Employee Documents')
                    ->schema([
                        RepeatableEntry::make('documents')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('document_name')
                                    ->label('Document Name'),

                                TextEntry::make('document_type')
                                    ->label('Type')
                                    ->badge(),

                                TextEntry::make('file_path')
                                    ->label('File')
                                    ->formatStateUsing(fn () => 'View Document')
                                    ->url(fn ($state) => asset('storage/' . $state))
                                    ->openUrlInNewTab(),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return EmployeesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployee::route('/create'),
            'view' => ViewEmployee::route('/{record}'),
            'edit' => EditEmployee::route('/{record}/edit'),
        ];
    }
}
