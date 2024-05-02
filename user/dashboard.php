<?php
require_once "header.php";
require_once "sidenav.php";

// Assuming the session is already started
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Fetch user data based on username
    // You need to replace this with your actual database query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found";
    }
    $stmt->close();
} else {
    // Redirect to login page if session username is not set
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $newUsername = $_POST["username"];

    // Validate name
    if (empty($name)) {
        $errorMsg .= "Name is required.<br>";
    }

    // Validate username
    if (empty($newUsername)) {
        $errorMsg .= "Username is required.<br>";
    } elseif (!preg_match("/^[a-zA-Z0-9_ ]+$/", $newUsername)) {
        $errorMsg .= "Username should contain only letters, numbers, and underscores.<br>";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
        $stmt->bind_param("si", $newUsername, $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errorMsg .= "Username is already taken. Please choose a different one.<br>";
        }
        $stmt->close();
    }

    // Validate email
    if (empty($email)) {
        $errorMsg .= "Email is required.<br>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.<br>";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errorMsg .= "Email is already registered. Please use a different one.<br>";
        }
        $stmt->close();
    }

    // Validate phone
    if (empty($phone)) {
        $errorMsg .= "Phone number is required.<br>";
    } elseif (!preg_match("/^\d{11}$/", $phone)) {
        $errorMsg .= "Phone number should contain 11 digits.<br>";
    } else {
        // Check if phone number already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone = ? AND id != ?");
        $stmt->bind_param("si", $phone, $user['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errorMsg .= "Phone number is already registered. Please use a different one.<br>";
        }
        $stmt->close();
    }

    // If no errors, update profile
    if (empty($errorMsg)) {
        // Update profile in database
        $stmt = $conn->prepare("UPDATE users SET name=?, address=?, phone=?, email=?, username=? WHERE username=?");
        $stmt->bind_param("ssssss", $name, $address, $phone, $email, $newUsername, $username);
        if ($stmt->execute()) {
            $successMsg = "Profile updated successfully.";
        } else {
            $errorMsg = "Error updating profile: " . $stmt->error;
        }
        $stmt->close();
    }
}

?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="page-header">Update Profile</h1>
                <div class="container">
                    <?php if (!empty($errorMsg)) echo "<div class='alert alert-danger' style='width: 50%;'>$errorMsg</div>"; ?>
                    <?php if (!empty($successMsg)) echo "<div class='alert alert-success' style='width: 50%;'>$successMsg</div>"; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name'] ?? ''; ?>" required style="width: 50%;">
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address'] ?? ''; ?>" required style="width: 50%;">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone'] ?? ''; ?>" required style="width: 50%;">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email'] ?? ''; ?>" required style="width: 50%;">
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username'] ?? ''; ?>" required style="width: 50%;">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="dashboard.php" class="btn btn-info">Refresh Page</a>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="page-header">Profile Information</h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $user['name'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo $user['address'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo $user['phone'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $user['email'] ?? ''; ?></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><?php echo $user['username'] ?? ''; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
