<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
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

<h2>Attendance Report</h2>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Date</th>
            <th>Status</th>
            <th>Check In</th>
            <th>Check Out</th>
        </tr>
    </thead>

    <tbody>
        @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->employee?->name ?? '-' }}</td>
                <td>{{ $attendance->attendance_date }}</td>
                <td>{{ $attendance->status }}</td>
                <td>{{ $attendance->check_in ?? '-' }}</td>
                <td>{{ $attendance->check_out ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
