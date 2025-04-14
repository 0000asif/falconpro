<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History</title>

    <style>
        /* Reset some browser default styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }


        /* Print page styles */
        @media print {

            body {
                margin: 0;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Attendance History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Check-In</th>
                    <th>Check-In IP</th>
                    <th>Check-Out</th>
                    <th>Check-Out IP</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($attendences as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                        <td>{{ $value->employee->name ?? 'N/A' }}</td>
                        <td>{{ $value->check_in ? date('d-m-Y H:i:s', strtotime($value->check_in)) : 'N/A' }}</td>
                        <td>{{ $value->check_in_ip }}</td>
                        <td>{{ $value->check_out ? date('d-m-Y H:i:s', strtotime($value->check_out)) : 'N/A' }}</td>
                        <td>{{ $value->check_out_ip }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
