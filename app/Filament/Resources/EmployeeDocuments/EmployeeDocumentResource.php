<?php

namespace App\Filament\Resources\EmployeeDocuments;

use App\Filament\Resources\EmployeeDocuments\Pages\CreateEmployeeDocument;
use App\Filament\Resources\EmployeeDocuments\Pages\EditEmployeeDocument;
use App\Filament\Resources\EmployeeDocuments\Pages\ListEmployeeDocuments;
use App\Filament\Resources\EmployeeDocuments\Schemas\EmployeeDocumentForm;
use App\Filament\Resources\EmployeeDocuments\Tables\EmployeeDocumentsTable;
use App\Models\EmployeeDocument;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class EmployeeDocumentResource extends Resource
{
    protected static ?string $model = EmployeeDocument::class;

    protected static ?string $navigationLabel = 'Employee Documents';

    public static function form(Schema $schema): Schema
    {
        return EmployeeDocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeDocumentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployeeDocuments::route('/'),
            'create' => CreateEmployeeDocument::route('/create'),
            'edit' => EditEmployeeDocument::route('/{record}/edit'),
        ];
    }
}
