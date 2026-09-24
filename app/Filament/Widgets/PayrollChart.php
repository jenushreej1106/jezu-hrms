<?php

namespace App\Filament\Widgets;

use App\Models\Payroll;
use Filament\Widgets\ChartWidget;

class PayrollChart extends ChartWidget
{
    protected ?string $heading = 'Payroll Overview';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Payroll Count',
                    'data' => [
                        Payroll::where('status', 'Pending')->count(),
                        Payroll::where('status', 'Paid')->count(),
                        Payroll::where('status', 'Cancelled')->count(),
                    ],
                ],
            ],

            'labels' => [
                'Pending',
                'Paid',
                'Cancelled',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
