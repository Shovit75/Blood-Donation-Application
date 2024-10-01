<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donated To Data PDF</title>
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
    <h2>List of Blood Requests, {{$webusername}} has enrolled to help.</h2>
    <table>
        <thead>
            <tr>
                <th>Patient's Name</th>
                <th>Blood Group</th>
                <th>Hospital</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bloodencoded as $req)
            <tr>
                <td>{{ $req->patient_name }}</td>
                <td>{{ $req->blood_group }}</td>
                <td>{{ $req->hospital_name }}</td>
                <td>{{ $req->required_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
