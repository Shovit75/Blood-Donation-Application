<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donors Data PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>List of Donors for {{$bloodreq_patient_name}}</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Blood Group</th>
                <th>Address</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donorsData as $donor)
            <tr>
                <td>{{ $donor['name'] }}</td>
                <td>{{ $donor['blood_group'] }}</td>
                <td>{{ $donor['address'] }}</td>
                <td>{{ $donor['phone'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
