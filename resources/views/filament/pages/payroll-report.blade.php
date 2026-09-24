<x-filament-panels::page>

    @php
        $summary = $this->getSummary();
        $payrolls = $this->getPayrollData();
        $employees = $this->getEmployees();
        $rupee = html_entity_decode('&#8377;');
    @endphp

    {{-- FILTER FORM --}}
    <x-filament::section heading="Filter Payroll">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm font-medium mb-2">
                    From Month
                </label>

                <input
                    type="month"
                    wire:model="dateFrom"
                    class="fi-input block w-full rounded-lg border-gray-300"
                >
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">
                    To Month
                </label>

                <input
                    type="month"
                    wire:model="dateTo"
                    class="fi-input block w-full rounded-lg border-gray-300"
                >
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">
                    Employee
                </label>

                <select
                    wire:model="employeeId"
                    class="fi-select block w-full rounded-lg border-gray-300"
                >
                    <option value="">All Employees</option>

                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">
                    Status
                </label>

                <select
                    wire:model="status"
                    class="fi-select block w-full rounded-lg border-gray-300"
                >
                    <option value="">All Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>
            </div>

        </div>

        <div class="flex gap-3 mt-5">

            <x-filament::button wire:click="applyFilter">
                Apply Filter
            </x-filament::button>

            <x-filament::button
                color="gray"
                wire:click="resetFilter"
            >
                Reset
            </x-filament::button>

        </div>

    </x-filament::section>


    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <x-filament::section>
            <div class="text-sm text-gray-500">
                Total Payrolls
            </div>

            <div class="text-3xl font-bold mt-2">
                {{ $summary['total'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">
                Paid
            </div>

            <div class="text-3xl font-bold mt-2">
                {{ $summary['paid'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">
                Pending
            </div>

            <div class="text-3xl font-bold mt-2">
                {{ $summary['pending'] }}
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">
                Total Net Salary
            </div>

            <div class="text-2xl font-bold mt-2">
                {{ $rupee }}{{ number_format($summary['total_salary'], 2) }}
            </div>
        </x-filament::section>

    </div>


    {{-- PAYROLL TABLE --}}
<x-filament::section heading="Payroll Details">

    <div style="width: 100%; overflow-x: auto;">

        <table style="width: 100%; min-width: 1100px; border-collapse: separate; border-spacing: 0;">

            <thead>
                <tr style="border-bottom: 1px solid #374151;">

                    <th style="padding: 16px 28px; text-align: left; white-space: nowrap;">
                        Employee
                    </th>

                    <th style="padding: 16px 28px; text-align: left; white-space: nowrap;">
                        Salary Month
                    </th>

                    <th style="padding: 16px 28px; text-align: right; white-space: nowrap;">
                        Basic Salary
                    </th>

                    <th style="padding: 16px 28px; text-align: right; white-space: nowrap;">
                        Allowances
                    </th>

                    <th style="padding: 16px 28px; text-align: right; white-space: nowrap;">
                        Deductions
                    </th>

                    <th style="padding: 16px 28px; text-align: right; white-space: nowrap;">
                        Net Salary
                    </th>

                    <th style="padding: 16px 28px; text-align: center; white-space: nowrap;">
                        Status
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse($payrolls as $payroll)

                    <tr style="border-bottom: 1px solid #2d2d2d;">

                        <td style="padding: 18px 28px; white-space: nowrap;">
                            <strong>
                                {{ $payroll->employee?->name ?? 'N/A' }}
                            </strong>
                        </td>

                        <td style="padding: 18px 28px; white-space: nowrap;">
                            {{ $payroll->salary_month }}
                        </td>

                        <td style="padding: 18px 28px; text-align: right; white-space: nowrap;">
                            {{ $rupee }}{{ number_format($payroll->basic_salary, 2) }}
                        </td>

                        <td style="padding: 18px 28px; text-align: right; white-space: nowrap;">
                            {{ $rupee }}{{ number_format($payroll->allowances ?? 0, 2) }}
                        </td>

                        <td style="padding: 18px 28px; text-align: right; white-space: nowrap;">
                            {{ $rupee }}{{ number_format($payroll->deductions ?? 0, 2) }}
                        </td>

                        <td style="padding: 18px 28px; text-align: right; white-space: nowrap;">
                            <strong>
                                {{ $rupee }}{{ number_format($payroll->net_salary, 2) }}
                            </strong>
                        </td>

                        <td style="padding: 18px 28px; text-align: center; white-space: nowrap;">

                            @if($payroll->status === 'Paid')

                                <span style="
                                    display: inline-block;
                                    padding: 6px 14px;
                                    border-radius: 9999px;
                                    background: rgba(34, 197, 94, 0.15);
                                    color: #4ade80;
                                    font-size: 12px;
                                    font-weight: 600;
                                ">
                                    Paid
                                </span>

                            @else

                                <span style="
                                    display: inline-block;
                                    padding: 6px 14px;
                                    border-radius: 9999px;
                                    background: rgba(234, 179, 8, 0.15);
                                    color: #facc15;
                                    font-size: 12px;
                                    font-weight: 600;
                                ">
                                    Pending
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center;">
                            No payroll records found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-filament::section>
</x-filament-panels::page>


