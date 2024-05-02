<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $license_number = $_POST["license_number"];
    $address = $_POST["address"];

    // Check if email, phone, and license number already exist
    $stmt_check = $conn->prepare("SELECT * FROM drivers WHERE email = ? OR phone = ? OR license_number = ?");
    $stmt_check->bind_param("sss", $email, $phone, $license_number);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Email, phone, or license number already exists!</p>";
    } else {
        // Insert the driver if email, phone, and license number are unique
        $stmt = $conn->prepare("INSERT INTO drivers (name, email, phone, license_number, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $license_number, $address);

        if ($stmt->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>New driver added successfully</p>";
        } else {
            $msg = "<p  class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Driver</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Driver</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" pattern="[0-9]{11}" required>
                    <small class="text-muted">Please enter phone number in Pakistani format (11 digits).</small>
                </div>
                <div class="form-group">
                    <label for="license_number">License Number:</label>
                    <input type="text" class="form-control" id="license_number" name="license_number" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Driver</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
