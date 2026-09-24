<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendancesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Attendance::with('employee')
            ->orderByDesc('attendance_date')
            ->get()
            ->map(function ($attendance) {
                return [
                    $attendance->employee?->name,
                    $attendance->attendance_date,
                    $attendance->status,
                    $attendance->check_in,
                    $attendance->check_out,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Date',
            'Status',
            'Check In',
            'Check Out',
        ];
    }
}
