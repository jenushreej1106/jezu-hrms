<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payroll Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #444;
            padding: 7px;
            text-align: left;
        }

        th {
            background: #eeeeee;
        }

        .amount {
            text-align: right;
        }
    </style>
</head>

<body>

<h2>Payroll Report</h2>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Salary Month</th>
            <th>Basic Salary</th>
            <th>Allowances</th>
            <th>Deductions</th>
            <th>Net Salary</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($payrolls as $payroll)
            <tr>
                <td>{{ $payroll->employee?->name ?? 'N/A' }}</td>
                <td>{{ $payroll->salary_month }}</td>
                <td class="amount">?{{ number_format($payroll->basic_salary, 2) }}</td>
                <td class="amount">?{{ number_format($payroll->allowances, 2) }}</td>
                <td class="amount">?{{ number_format($payroll->deductions, 2) }}</td>
                <td class="amount">?{{ number_format($payroll->net_salary, 2) }}</td>
                <td>{{ $payroll->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No payroll records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
