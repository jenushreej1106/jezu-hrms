<?php

namespace App\Exports;

use App\Models\EmployeeDocument;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeDocumentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return EmployeeDocument::with('employee')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($document) {
                return [
                    $document->employee?->name,
                    $document->document_name,
                    $document->document_type,
                    $document->file_path,
                    $document->created_at?->format('d M Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Document Name',
            'Document Type',
            'File Path',
            'Uploaded Date',
        ];
    }
}
