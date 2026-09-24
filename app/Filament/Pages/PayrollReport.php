<?php

namespace App\Filament\Pages;

use App\Models\Employee;
use App\Models\Payroll;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class PayrollReport extends Page
{
    protected string $view = 'filament.pages.payroll-report';

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    public ?string $employeeId = null;

    public ?string $status = null;

    public function mount(): void
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m');
        $this->employeeId = '';
        $this->status = '';
    }

    public function applyFilter(): void
    {
        // Filters are applied automatically through the report query.
    }

    public function resetFilter(): void
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m');
        $this->employeeId = '';
        $this->status = '';
    }

    public function getEmployees()
    {
        return Employee::orderBy('name')->get();
    }

    protected function filteredPayrolls()
    {
        $from = Carbon::createFromFormat('Y-m', $this->dateFrom)->startOfMonth();
        $to = Carbon::createFromFormat('Y-m', $this->dateTo)->startOfMonth();

        return Payroll::with('employee')
            ->when($this->employeeId, function ($query) {
                $query->where('employee_id', $this->employeeId);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->get()
            ->filter(function ($payroll) use ($from, $to) {
                try {
                    $month = Carbon::createFromFormat(
                        'F Y',
                        $payroll->salary_month
                    )->startOfMonth();

                    return $month->betweenIncluded($from, $to);
                } catch (\Throwable $e) {
                    return false;
                }
            })
            ->sortByDesc(function ($payroll) {
                return Carbon::createFromFormat(
                    'F Y',
                    $payroll->salary_month
                )->timestamp;
            })
            ->values();
    }

    public function getPayrollData()
    {
        return $this->filteredPayrolls();
    }

    public function getSummary(): array
    {
        $payrolls = $this->filteredPayrolls();

        return [
            'total' => $payrolls->count(),

            'paid' => $payrolls
                ->where('status', 'Paid')
                ->count(),

            'pending' => $payrolls
                ->where('status', 'Pending')
                ->count(),

            'total_basic' => $payrolls->sum('basic_salary'),

            'total_allowances' => $payrolls->sum('allowances'),

            'total_deductions' => $payrolls->sum('deductions'),

            'total_salary' => $payrolls->sum('net_salary'),
        ];
    }
}
