<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Website</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding-top: 50px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }
        .btn-primary, .btn-success {
            margin: 10px;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 30px;
        }
        .btn-primary:hover, .btn-success:hover {
            opacity: 0.8;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Online Logistics System</h1>
        <p>We provide you to the best facility of logistics on very minimal rates.</p>
        <i class="icon fas fa-globe"></i>
        <br>
        <a href="user/sign-in.php" class="btn btn-primary">User Login</a>
        <a href="user/sign-up.php" class="btn btn-success">User Registration</a>
        <br>
        <a href="admin/sign-in.php" class="btn btn-primary">Admin Login</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>