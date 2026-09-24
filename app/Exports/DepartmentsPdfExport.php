<?php

namespace App\Exports;

use App\Models\Department;
use Barryvdh\DomPDF\Facade\Pdf;

class DepartmentsPdfExport
{
    public static function download()
    {
        $departments = Department::withCount('employees')
            ->orderBy('name')
            ->get();

        return Pdf::loadView('pdf.departments', [
            'departments' => $departments,
        ])->download('departments.pdf');
    }
}
