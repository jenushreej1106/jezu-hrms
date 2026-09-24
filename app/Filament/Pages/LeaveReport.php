<?php

namespace App\Filament\Pages;

use App\Models\Leave;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class LeaveReport extends Page
{
    protected string $view = 'filament.pages.leave-report';

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    public function mount(): void
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $this->dateTo = Carbon::now()->endOfMonth()->toDateString();
    }

    public function getLeaveData()
    {
        return Leave::with('employee')
            ->whereBetween('start_date', [$this->dateFrom, $this->dateTo])
            ->orderByDesc('start_date')
            ->get();
    }

    public function getSummary(): array
    {
        $query = Leave::query()
            ->whereBetween('start_date', [$this->dateFrom, $this->dateTo]);

        return [
            'total' => (clone $query)->count(),
            'approved' => (clone $query)->where('status', 'Approved')->count(),
            'pending' => (clone $query)->where('status', 'Pending')->count(),
            'rejected' => (clone $query)->where('status', 'Rejected')->count(),
        ];
    }
}
