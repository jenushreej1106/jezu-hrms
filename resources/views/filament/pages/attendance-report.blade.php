<x-filament-panels::page>

    @php
        $summary = $this->getSummary();
        $attendance = $this->getAttendanceData();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <x-filament::section>
            <div class="text-sm text-gray-500">Total Attendance</div>
            <div class="text-3xl font-bold">{{ $summary['total'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Present</div>
            <div class="text-3xl font-bold">{{ $summary['present'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Absent</div>
            <div class="text-3xl font-bold">{{ $summary['absent'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Half Day</div>
            <div class="text-3xl font-bold">{{ $summary['half_day'] }}</div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-sm text-gray-500">Leave</div>
            <div class="text-3xl font-bold">{{ $summary['leave'] }}</div>
        </x-filament::section>

    </div>

    <x-filament::section heading="Attendance Report">

        <div class="w-full overflow-x-auto rounded-xl">

            <table
                class="w-full min-w-[900px] text-sm"
                style="border-collapse: separate; border-spacing: 0 8px;"
            >

                <thead>
                    <tr>
                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 25%; padding: 16px 28px;"
                        >
                            Employee
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 18%; padding: 16px 28px;"
                        >
                            Date
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 18%; padding: 16px 28px;"
                        >
                            Status
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 19%; padding: 16px 28px;"
                        >
                            Check In
                        </th>

                        <th
                            class="text-left font-semibold whitespace-nowrap"
                            style="width: 20%; padding: 16px 28px;"
                        >
                            Check Out
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($attendance as $record)

                        <tr
                            class="hover:bg-gray-50 dark:hover:bg-gray-800/50"
                            style="border-bottom: 1px solid #e5e7eb;"
                        >

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $record->employee?->name ?? 'N/A' }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ Carbon\Carbon::parse($record->attendance_date)->format('d M Y') }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $record->status }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $record->check_in ?? '-' }}
                            </td>

                            <td
                                class="whitespace-nowrap"
                                style="padding: 18px 28px;"
                            >
                                {{ $record->check_out ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="5"
                                class="text-center text-gray-500"
                                style="padding: 32px;"
                            >
                                No attendance records found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </x-filament::section>

</x-filament-panels::page>