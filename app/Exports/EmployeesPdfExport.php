<?php

namespace App\Exports;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeesPdfExport
{
    public static function download()
    {
        $employees = Employee::with('department')
            ->orderBy('name')
            ->get();

        return Pdf::loadView('pdf.employees', [
            'employees' => $employees,
        ])->download('employees.pdf');
    }
}
