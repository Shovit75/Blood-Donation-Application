<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants Data PDF</title>
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
    <h1>List of participants for {{$bdcamps_name}}</h1>
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
            @if($participantsData)
            @foreach ($participantsData as $p)
            <tr>
                <td>{{ $p['participantName'] }}</td>
                <td>{{ $p['participantBg'] }}</td>
                <td>{{ $p['participantAddress'] }}</td>
                <td>{{ $p['participantPhone'] }}</td>
            </tr>
            @endforeach
            @else
            No data added.
            @endif
        </tbody>
    </table>
</body>
</html>
