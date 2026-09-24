<?php

namespace App\Exports;

use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendancesPdfExport
{
    public static function download()
    {
        $attendances = Attendance::with('employee')
            ->orderByDesc('attendance_date')
            ->get();

        return Pdf::loadView('pdf.attendances', [
            'attendances' => $attendances,
        ])->download('attendance.pdf');
    }
}
