{{-- PAYROLL TABLE --}}
<x-filament::section heading="Payroll Details">

    <div class="overflow-x-auto">

        <table class="w-full min-w-[1100px] text-sm">

            <thead>
                <tr class="border-b border-gray-700">

                    <th class="px-6 py-4 text-left whitespace-nowrap font-semibold">
                        Employee
                    </th>

                    <th class="px-6 py-4 text-left whitespace-nowrap font-semibold">
                        Salary Month
                    </th>

                    <th class="px-6 py-4 text-right whitespace-nowrap font-semibold">
                        Basic Salary
                    </th>

                    <th class="px-6 py-4 text-right whitespace-nowrap font-semibold">
                        Allowances
                    </th>

                    <th class="px-6 py-4 text-right whitespace-nowrap font-semibold">
                        Deductions
                    </th>

                    <th class="px-6 py-4 text-right whitespace-nowrap font-semibold">
                        Net Salary
                    </th>

                    <th class="px-6 py-4 text-center whitespace-nowrap font-semibold">
                        Status
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse($payrolls as $payroll)

                    <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">

                        <td class="px-6 py-5 whitespace-nowrap font-medium">
                            {{ $payroll->employee?->name ?? 'N/A' }}
                        </td>

                        <td class="px-6 py-5 whitespace-nowrap">
                            {{ $payroll->salary_month }}
                        </td>

                        <td class="px-6 py-5 text-right whitespace-nowrap">
                            {{ $rupee }}{{ number_format($payroll->basic_salary, 2) }}
                        </td>

                        <td class="px-6 py-5 text-right whitespace-nowrap">
                            {{ $rupee }}{{ number_format($payroll->allowances ?? 0, 2) }}
                        </td>

                        <td class="px-6 py-5 text-right whitespace-nowrap">
                            {{ $rupee }}{{ number_format($payroll->deductions ?? 0, 2) }}
                        </td>

                        <td class="px-6 py-5 text-right whitespace-nowrap font-bold">
                            {{ $rupee }}{{ number_format($payroll->net_salary, 2) }}
                        </td>

                        <td class="px-6 py-5 text-center whitespace-nowrap">

                            @if($payroll->status === 'Paid')

                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400">
                                    Paid
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400">
                                    Pending
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="7"
                            class="px-6 py-12 text-center text-gray-500"
                        >
                            No payroll records found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-filament::section>
