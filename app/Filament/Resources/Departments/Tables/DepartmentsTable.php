<?php

namespace App\Filament\Resources\Departments\Tables;

use App\Exports\DepartmentsExport;
use App\Models\Department;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Department Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('employees_count')
                    ->label('Employees')
                    ->counts('employees')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created Date')
                    ->date('d M Y')
                    ->sortable(),
            ])

            ->filters([
                Filter::make('created_at')
                    ->label('Created Date')
                    ->form([
                        DatePicker::make('from')
                            ->label('From'),

                        DatePicker::make('until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                filled($data['from'] ?? null),
                                fn (Builder $query) =>
                                    $query->whereDate('created_at', '>=', $data['from'])
                            )
                            ->when(
                                filled($data['until'] ?? null),
                                fn (Builder $query) =>
                                    $query->whereDate('created_at', '<=', $data['until'])
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
                            new DepartmentsExport,
                            'departments.xlsx'
                        );
                    }),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('departments.export-pdf'))
                    ->openUrlInNewTab(),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
