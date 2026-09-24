<?php

namespace App\Filament\Widgets;

use App\Models\Payroll;
use Filament\Widgets\ChartWidget;

class MonthlyPayrollChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Payroll Trend';

    protected function getData(): array
    {
        $months = collect(range(1, 12));

        $labels = $months->map(function ($month) {
            return date('M', mktime(0, 0, 0, $month, 1));
        })->toArray();

        $data = $months->map(function ($month) {
            return Payroll::query()
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->sum('net_salary');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Net Payroll',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
