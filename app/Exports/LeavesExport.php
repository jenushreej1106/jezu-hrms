<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeavesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Leave::with('employee')
            ->orderByDesc('start_date')
            ->get()
            ->map(function ($leave) {
                return [
                    $leave->employee?->name,
                    $leave->leave_type,
                    $leave->start_date,
                    $leave->end_date,
                    $leave->reason,
                    $leave->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Leave Type',
            'Start Date',
            'End Date',
            'Reason',
            'Status',
        ];
    }
}
