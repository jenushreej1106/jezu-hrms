<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employees Report</title>
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
            border: 1px solid #000;
            padding: 7px;
            text-align: left;
        }

        th {
            background: #eeeeee;
        }
    </style>
</head>
<body>

<h2>Employee Report</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Job Title</th>
            <th>Department</th>
            <th>Joining Date</th>
            <th>Salary</th>
        </tr>
    </thead>

    <tbody>
        @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ $employee->job_title }}</td>
                <td>{{ $employee->department?->name }}</td>
                <td>{{ $employee->joining_date }}</td>
                <td>?{{ number_format($employee->salary, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
