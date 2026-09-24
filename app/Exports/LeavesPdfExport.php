<?php

namespace App\Exports;

use App\Models\Leave;
use Barryvdh\DomPDF\Facade\Pdf;

class LeavesPdfExport
{
    public static function download()
    {
        $leaves = Leave::with('employee')
            ->orderByDesc('start_date')
            ->get();

        return Pdf::loadView('pdf.leaves', [
            'leaves' => $leaves,
        ])->download('leaves.pdf');
    }
}
