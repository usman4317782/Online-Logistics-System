<?php
session_start();
if (isset($_SESSION['username'])) {
    echo "<script>window.location.replace('dashboard.php');</script>";
}
require_once "db_connect.php";

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username; 
            // $msg = "Login successful. Welcome, $username!";
            // Redirect to a dashboard or home page
            header("Location: dashboard.php");
        } else {
            $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-2'>Invalid password.</p>";
        }
    } else {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-2'>User not found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php echo $msg ?? ""; ?>
                <h2 class="text text-center text-info text-uppercase">Sign In</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign In</button>
                    <small class="text text-muted">Not already registered? <a href="sign-up.php" target="__blank">Sign Up</a></small>
                </form>
            </div>
        </div>
    </div>
</body>

</html>