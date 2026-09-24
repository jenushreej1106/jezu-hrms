<?php

namespace App\Filament\Resources\EmployeeDocuments\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('document_name')
                    ->label('Document Name')
                    ->required()
                    ->maxLength(255),

                Select::make('document_type')
                    ->label('Document Type')
                    ->options([
                        'Aadhaar / ID Proof' => 'Aadhaar / ID Proof',
                        'Resume' => 'Resume',
                        'Offer Letter' => 'Offer Letter',
                        'Certificate' => 'Certificate',
                        'Other' => 'Other',
                    ])
                    ->searchable(),

                FileUpload::make('file_path')
                    ->label('Document File')
                    ->disk('public')
                    ->directory('employee-documents')
                    ->required()
                    ->downloadable()
                    ->openable()
                    ->maxSize(5120),
            ]);
    }
}
