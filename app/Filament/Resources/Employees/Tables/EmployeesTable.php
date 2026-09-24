<?php

namespace App\Filament\Resources\Employees\Tables;

use App\Exports\EmployeesExport;
use App\Models\Department;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Photo')
                    ->state(fn ($record) => asset('storage/' . $record->photo))
                    ->circular()
                    ->size(50),

                TextColumn::make('name')
                    ->label('Employee Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make('job_title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('department.name')
                    ->label('Department')
                    ->sortable(),

                TextColumn::make('joining_date')
                    ->label('Joining Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('salary')
                    ->label('Salary')
                    ->money('INR')
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->options(
                        Department::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable(),

                SelectFilter::make('job_title')
                    ->label('Job Title')
                    ->options(
                        fn (): array => Employee::query()
                            ->whereNotNull('job_title')
                            ->where('job_title', '!=', '')
                            ->distinct()
                            ->orderBy('job_title')
                            ->pluck('job_title', 'job_title')
                            ->toArray()
                    )
                    ->searchable(),

                Filter::make('salary_range')
                    ->label('Salary Range')
                    ->form([
                        TextInput::make('min_salary')
                            ->label('Minimum Salary')
                            ->numeric()
                            ->prefix('Rs.'),

                        TextInput::make('max_salary')
                            ->label('Maximum Salary')
                            ->numeric()
                            ->prefix('Rs.'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                filled($data['min_salary'] ?? null),
                                fn (Builder $query) =>
                                    $query->where(
                                        'salary',
                                        '>=',
                                        $data['min_salary']
                                    )
                            )
                            ->when(
                                filled($data['max_salary'] ?? null),
                                fn (Builder $query) =>
                                    $query->where(
                                        'salary',
                                        '<=',
                                        $data['max_salary']
                                    )
                            );
                    }),

                Filter::make('joining_date')
                    ->label('Joining Date')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Date'),

                        DatePicker::make('until')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                filled($data['from'] ?? null),
                                fn (Builder $query) =>
                                    $query->whereDate(
                                        'joining_date',
                                        '>=',
                                        $data['from']
                                    )
                            )
                            ->when(
                                filled($data['until'] ?? null),
                                fn (Builder $query) =>
                                    $query->whereDate(
                                        'joining_date',
                                        '<=',
                                        $data['until']
                                    )
                            );
                    }),
            ])

            ->filtersTriggerAction(
                fn ($action) => $action->label('Filters')->button()
            )

            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                Action::make('exportExcel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return Excel::download(
                            new EmployeesExport,
                            'employees.xlsx'
                        );
                    }),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('employees.export-pdf'))
                    ->openUrlInNewTab(),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}