<x-filament-panels::page>

    @php
        $summary = $this->getSummary();
        $leaves = $this->getLeaveData();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <x-filament::section>
            <div class="text-sm text-gray-500">Total Requests</div>
            <div class="text-3xl font-bold">{{ $summary['total'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Approved</div>
            <div class="text-3xl font-bold">{{ $summary['approved'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Pending</div>
            <div class="text-3xl font-bold">{{ $summary['pending'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Rejected</div>
            <div class="text-3xl font-bold">{{ $summary['rejected'] }}</div>
        </x-filament::section>

    </div>

    <x-filament::section heading="Leave Report">

        <div class="w-full overflow-x-auto rounded-xl">

            <table
                class="w-full min-w-[1000px] text-sm"
                style="border-collapse: separate; border-spacing: 0 8px;"
            >

                <thead>
                    <tr>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 20%; padding: 16px 28px;"
                        >
                            Employee
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 20%; padding: 16px 28px;"
                        >
                            Leave Type
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 20%; padding: 16px 28px;"
                        >
                            Start Date
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 20%; padding: 16px 28px;"
                        >
                            End Date
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 20%; padding: 16px 28px;"
                        >
                            Status
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($leaves as $leave)

                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-gray-800/50"
                            style="border-bottom: 1px solid #e5e7eb;"
                        >

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $leave->employee?->name ?? 'N/A' }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $leave->leave_type }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $leave->status }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="text-center text-gray-500"
                                style="padding: 32px;"
                            >
                                No leave records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </x-filament::section>

</x-filament-panels::page>