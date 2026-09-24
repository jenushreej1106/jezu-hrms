<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Employee::with('department')
            ->orderBy('name')
            ->get()
            ->map(function ($employee) {
                return [
                    $employee->name,
                    $employee->email,
                    $employee->phone,
                    $employee->job_title,
                    $employee->department?->name,
                    $employee->joining_date,
                    $employee->salary,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Email',
            'Phone',
            'Job Title',
            'Department',
            'Joining Date',
            'Salary',
        ];
    }
}
