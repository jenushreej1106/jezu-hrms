<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Actions
        </x-slot>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">

            <a
                href="{{ route('filament.admin.resources.employees.create') }}"
                class="fi-btn fi-btn-color-primary"
            >
                ➕ Add Employee
            </a>

            <a
                href="{{ route('filament.admin.resources.departments.create') }}"
                class="fi-btn fi-btn-color-primary"
            >
                🏢 Add Department
            </a>

            <a
                href="{{ route('filament.admin.resources.attendances.create') }}"
                class="fi-btn fi-btn-color-primary"
            >
                🕐 Add Attendance
            </a>

            <a
                href="{{ route('filament.admin.resources.leaves.create') }}"
                class="fi-btn fi-btn-color-primary"
            >
                🏖️ Apply Leave
            </a>

            <a
                href="{{ route('filament.admin.resources.payrolls.create') }}"
                class="fi-btn fi-btn-color-primary"
            >
                💰 Create Payroll
            </a>

        </div>
    </x-filament-widgets::widget>
</x-filament-widgets::widget>