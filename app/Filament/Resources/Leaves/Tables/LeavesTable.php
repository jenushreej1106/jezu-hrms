<?php

namespace App\Filament\Resources\Leaves\Tables;

use App\Exports\LeavesExport;
use App\Models\Employee;
use App\Models\Leave;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
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

class LeavesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('leave_type')
                    ->label('Leave Type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
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
                    ->label('Leave Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Approved' => 'Approved',
                        'Rejected' => 'Rejected',
                    ]),

                SelectFilter::make('leave_type')
                    ->label('Leave Type')
                    ->options(
                        Leave::query()
                            ->whereNotNull('leave_type')
                            ->where('leave_type', '!=', '')
                            ->distinct()
                            ->orderBy('leave_type')
                            ->pluck('leave_type', 'leave_type')
                            ->toArray()
                    )
                    ->searchable(),

                Filter::make('date_range')
                    ->label('Leave Date')
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
                                    $query->whereDate('start_date', '>=', $data['from'])
                            )
                            ->when(
                                filled($data['until'] ?? null),
                                fn (Builder $query) =>
                                    $query->whereDate('end_date', '<=', $data['until'])
                            );
                    }),
            ])

            ->filtersTriggerAction(
                fn ($action) => $action->label('Filters')->button()
            )

            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Leave $record): bool =>
                        $record->status === 'Pending'
                    )
                    ->action(function (Leave $record): void {
                        $record->update([
                            'status' => 'Approved',
                        ]);
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Leave $record): bool =>
                        $record->status === 'Pending'
                    )
                    ->action(function (Leave $record): void {
                        $record->update([
                            'status' => 'Rejected',
                        ]);
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                Action::make('exportExcel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return Excel::download(
                            new LeavesExport,
                            'leaves.xlsx'
                        );
                    }),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('leaves.export-pdf'))
                    ->openUrlInNewTab(),

                BulkActionGroup::make([
                    BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records): void {
                            $records->each(function (Leave $leave) {
                                if ($leave->status === 'Pending') {
                                    $leave->update([
                                        'status' => 'Approved',
                                    ]);
                                }
                            });
                        }),

                    BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records): void {
                            $records->each(function (Leave $leave) {
                                if ($leave->status === 'Pending') {
                                    $leave->update([
                                        'status' => 'Rejected',
                                    ]);
                                }
                            });
                        }),

                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
