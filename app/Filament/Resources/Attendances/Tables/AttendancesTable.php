<?php

namespace App\Filament\Resources\Attendances\Tables;

use App\Exports\AttendancesExport;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('attendance_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('check_in')
                    ->label('Check In'),

                TextColumn::make('check_out')
                    ->label('Check Out'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('employee_id')
                    ->label('Employee')
                    ->options(
                        Employee::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable(),

                SelectFilter::make('status')
                    ->label('Attendance Status')
                    ->options([
                        'Present' => 'Present',
                        'Absent' => 'Absent',
                        'Half Day' => 'Half Day',
                        'Leave' => 'Leave',
                    ]),

                Filter::make('date_range')
                    ->label('Date Range')
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
                                        'attendance_date',
                                        '>=',
                                        $data['from']
                                    )
                            )
                            ->when(
                                filled($data['until'] ?? null),
                                fn (Builder $query) =>
                                    $query->whereDate(
                                        'attendance_date',
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
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                Action::make('exportExcel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return Excel::download(
                            new AttendancesExport,
                            'attendance.xlsx'
                        );
                    }),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('attendances.export-pdf'))
                    ->openUrlInNewTab(),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
