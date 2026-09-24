<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payroll::with('employee')
            ->orderByDesc('salary_month')
            ->get()
            ->map(function ($payroll) {
                return [
                    $payroll->employee?->name,
                    $payroll->salary_month,
                    $payroll->basic_salary,
                    $payroll->allowances,
                    $payroll->deductions,
                    $payroll->net_salary,
                    $payroll->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Salary Month',
            'Basic Salary',
            'Allowances',
            'Deductions',
            'Net Salary',
            'Status',
        ];
    }
}
