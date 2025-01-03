<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $model["title"] ?? "Login Management" ?></title>
    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(to right, #a8e0a1, #6ab04c);
            color: #333;
        }

        .container {
            margin-top: 50px;
            max-width: 600px;
        }

        .card {
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }

        .alert {
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            color: #6ab04c;
        }

        .header p {
            font-size: 1.2rem;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container" id="loginManagementContainer">