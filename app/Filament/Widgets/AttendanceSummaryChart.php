<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Widgets\ChartWidget;

class AttendanceSummaryChart extends ChartWidget
{
    protected ?string $heading = 'Attendance Summary';

    protected function getData(): array
    {
        $present = Attendance::where('status', 'Present')->count();

        $absent = Attendance::where('status', 'Absent')->count();

        $halfDay = Attendance::where('status', 'Half Day')->count();

        $leave = Attendance::where('status', 'Leave')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Attendance',

                    'data' => [
                        max($present, 0.1),
                        max($absent, 0.1),
                        max($halfDay, 0.1),
                        max($leave, 0.1),
                    ],

                    'backgroundColor' => [
                        '#4F46E5',
                        '#33BAE4',
                        '#0d3a53',
                        '#8B5CF6',
                    ],

                    'borderColor' => '#FFFFFF',

                    'borderWidth' => 3,
                ],
            ],

            'labels' => [
                "Present ($present)",
                "Absent ($absent)",
                "Half Day ($halfDay)",
                "Leave ($leave)",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,

            'maintainAspectRatio' => false,

            'cutout' => '65%',

            'plugins' => [
                'legend' => [
                    'position' => 'bottom',

                    'labels' => [
                        'usePointStyle' => true,

                        'padding' => 20,

                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
        ];
    }
}