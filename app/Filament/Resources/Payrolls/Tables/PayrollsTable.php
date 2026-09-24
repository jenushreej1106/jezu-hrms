<?php

namespace App\Filament\Resources\Payrolls\Tables;

use App\Exports\PayrollsExport;
use App\Models\Employee;
use App\Models\Payroll;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class PayrollsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('salary_month')
                    ->label('Salary Month')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('basic_salary')
                    ->label('Basic Salary')
                    ->money('INR')
                    ->sortable(),

                TextColumn::make('allowances')
                    ->label('Allowances')
                    ->money('INR')
                    ->sortable(),

                TextColumn::make('deductions')
                    ->label('Deductions')
                    ->money('INR')
                    ->sortable(),

                TextColumn::make('net_salary')
                    ->label('Net Salary')
                    ->money('INR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
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
                    ->label('Status')
                    ->options([
                        'Pending' => 'Pending',
                        'Paid' => 'Paid',
                        'Cancelled' => 'Cancelled',
                    ]),

                Filter::make('salary_month')
                    ->label('Salary Month')
                    ->form([
                        DatePicker::make('from')
                            ->label('From Month')
                            ->native(false)
                            ->displayFormat('F Y'),

                        DatePicker::make('until')
                            ->label('To Month')
                            ->native(false)
                            ->displayFormat('F Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                filled($data['from'] ?? null),
                                fn (Builder $query) =>
                                    $query->where('salary_month', '>=', $data['from'])
                            )
                            ->when(
                                filled($data['until'] ?? null),
                                fn (Builder $query) =>
                                    $query->where('salary_month', '<=', $data['until'])
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
                            new PayrollsExport,
                            'payrolls.xlsx'
                        );
                    }),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('payrolls.export-pdf'))
                    ->openUrlInNewTab(),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
