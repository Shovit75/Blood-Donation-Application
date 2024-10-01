<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Details</title>
    <style>
        p{
            text-align: center;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
        }
        .message {
            margin-bottom: 20px;
        }
        .message p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <h2><p><a href="{{url('/')}}">Sikkim.Blood.Co</a></p></h2>
            <p>Hello, {{$webusername}}.</p>
            <p>Greetings from <a href="{{url('/')}}">Sikkim.blood.co</a> developed by NE Developers.</p>
            <p>You have a donor to help you. Please download, PDF of Blood Requests Added<br>
               from profile later to check who all have helped you with your requests.</p>
            <p>
                © {{date("Y")}} Copyright:
                <a href="https://nedevelopers.in/">NE Developers</a>
            </p>
        </div>
    </div>
</body>
</html>
