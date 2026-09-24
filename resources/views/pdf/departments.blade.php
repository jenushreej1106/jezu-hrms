<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Departments Report</title>

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
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eeeeee;
        }
    </style>
</head>

<body>

<h2>Departments Report</h2>

<table>
    <thead>
        <tr>
            <th>Department Name</th>
            <th>Description</th>
            <th>Employees</th>
            <th>Created Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->description ?? '-' }}</td>
                <td>{{ $department->employees_count }}</td>
                <td>{{ $department->created_at?->format('d M Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
