<?php

namespace App\Exports;

use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollsPdfExport
{
    public static function download()
    {
        $payrolls = Payroll::with('employee')
            ->orderByDesc('salary_month')
            ->get();

        return Pdf::loadView('pdf.payrolls', [
            'payrolls' => $payrolls,
        ])->download('payrolls.pdf');
    }
}
