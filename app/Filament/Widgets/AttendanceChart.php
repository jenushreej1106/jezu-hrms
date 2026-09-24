<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Widgets\ChartWidget;

class AttendanceChart extends ChartWidget
{
    protected ?string $heading = 'Attendance - Last 7 Days';
    protected function getData(): array
    {
        $dates = collect(range(6, 0))
            ->map(fn ($days) => now()->subDays($days)->toDateString());

        $present = [];
        $absent = [];
        $halfDay = [];
        $leave = [];

        foreach ($dates as $date) {
            $present[] = Attendance::whereDate('attendance_date', $date)
                ->where('status', 'Present')
                ->count();

            $absent[] = Attendance::whereDate('attendance_date', $date)
                ->where('status', 'Absent')
                ->count();

            $halfDay[] = Attendance::whereDate('attendance_date', $date)
                ->where('status', 'Half Day')
                ->count();

            $leave[] = Attendance::whereDate('attendance_date', $date)
                ->where('status', 'Leave')
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Present',
                    'data' => $present,
                ],
                [
                    'label' => 'Absent',
                    'data' => $absent,
                ],
                [
                    'label' => 'Half Day',
                    'data' => $halfDay,
                ],
                [
                    'label' => 'Leave',
                    'data' => $leave,
                ],
            ],

            'labels' => $dates
                ->map(fn ($date) => date('d M', strtotime($date)))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

