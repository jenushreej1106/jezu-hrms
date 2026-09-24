<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Department::withCount('employees')
            ->orderBy('name')
            ->get()
            ->map(function ($department) {
                return [
                    $department->name,
                    $department->description,
                    $department->employees_count,
                    $department->created_at?->format('d M Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Department Name',
            'Description',
            'Employees',
            'Created Date',
        ];
    }
}
