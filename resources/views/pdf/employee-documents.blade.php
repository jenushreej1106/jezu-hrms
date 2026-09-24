<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employee Documents Report</title>

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

<h2>Employee Documents Report</h2>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Document Name</th>
            <th>Document Type</th>
            <th>File</th>
            <th>Uploaded Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($documents as $document)
            <tr>
                <td>{{ $document->employee?->name ?? '-' }}</td>
                <td>{{ $document->document_name }}</td>
                <td>{{ $document->document_type ?? '-' }}</td>
                <td>{{ $document->file_path }}</td>
                <td>{{ $document->created_at?->format('d M Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
