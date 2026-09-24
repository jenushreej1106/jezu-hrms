<?php

namespace App\Filament\Resources\EmployeeDocuments\Tables;

use App\Exports\EmployeeDocumentsExport;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeDocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label('Employee')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('document_name')
                    ->label('Document Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('document_type')
                    ->label('Document Type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('file_path')
                    ->label('File')
                    ->formatStateUsing(fn () => 'View Document')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y h:i A')
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

                SelectFilter::make('document_type')
                    ->label('Document Type')
                    ->options([
                        'Aadhaar' => 'Aadhaar',
                        'PAN' => 'PAN',
                        'Passport' => 'Passport',
                        'Resume' => 'Resume',
                        'Certificate' => 'Certificate',
                        'Other' => 'Other',
                    ])
                    ->searchable(),

                Filter::make('uploaded_date')
                    ->label('Uploaded Date')
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
                            new EmployeeDocumentsExport,
                            'employee-documents.xlsx'
                        );
                    }),

                Action::make('exportPdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(route('employee-documents.export-pdf'))
                    ->openUrlInNewTab(),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
