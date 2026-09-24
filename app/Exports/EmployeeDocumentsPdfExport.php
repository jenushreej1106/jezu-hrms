<?php

namespace App\Exports;

use App\Models\EmployeeDocument;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeDocumentsPdfExport
{
    public static function download()
    {
        $documents = EmployeeDocument::with('employee')
            ->orderByDesc('created_at')
            ->get();

        return Pdf::loadView('pdf.employee-documents', [
            'documents' => $documents,
        ])->download('employee-documents.pdf');
    }
}
