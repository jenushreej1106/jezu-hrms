<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class AttendanceReport extends Page
{
    protected string $view = 'filament.pages.attendance-report';

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    public function mount(): void
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $this->dateTo = Carbon::now()->endOfMonth()->toDateString();
    }

    public function getAttendanceData()
    {
        return Attendance::with('employee')
            ->whereBetween('attendance_date', [
                $this->dateFrom,
                $this->dateTo,
            ])
            ->orderByDesc('attendance_date')
            ->get();
    }

    public function getSummary(): array
    {
        $query = Attendance::query()
            ->whereBetween('attendance_date', [
                $this->dateFrom,
                $this->dateTo,
            ]);

        return [
            'total' => (clone $query)->count(),
            'present' => (clone $query)->where('status', 'Present')->count(),
            'absent' => (clone $query)->where('status', 'Absent')->count(),
            'half_day' => (clone $query)->where('status', 'Half Day')->count(),
            'leave' => (clone $query)->where('status', 'Leave')->count(),
        ];
    }
}
