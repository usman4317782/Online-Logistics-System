<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $license_number = $_POST["license_number"];
    $address = $_POST["address"];

    // Check if the email already exists for another record
    $stmt_check = $conn->prepare("SELECT * FROM drivers WHERE email = ? AND id <> ?");
    $stmt_check->bind_param("si", $email, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Email already exists for another record!</p>";
    } else {
        // Check if the phone already exists for another record
        $stmt_check_phone = $conn->prepare("SELECT * FROM drivers WHERE phone = ? AND id <> ?");
        $stmt_check_phone->bind_param("si", $phone, $id);
        $stmt_check_phone->execute();
        $result_check_phone = $stmt_check_phone->get_result();

        if ($result_check_phone->num_rows > 0) {
            $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Phone number already exists for another record!</p>";
        } else {
            // Check if the license number already exists for another record
            $stmt_check_license = $conn->prepare("SELECT * FROM drivers WHERE license_number = ? AND id <> ?");
            $stmt_check_license->bind_param("si", $license_number, $id);
            $stmt_check_license->execute();
            $result_check_license = $stmt_check_license->get_result();

            if ($result_check_license->num_rows > 0) {
                $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>License number already exists for another record!</p>";
            } else {
                // Update the driver record if email, phone, and license number are unique
                $stmt = $conn->prepare("UPDATE drivers SET name = ?, email = ?, phone = ?, license_number = ?, address = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $name, $email, $phone, $license_number, $address, $id);

                if ($stmt->execute()) {
                    $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Driver record updated successfully</p>";
                } else {
                    $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }
        }
    }

    $stmt_check->close();
    $stmt_check_phone->close();
    $stmt_check_license->close();
}

// Fetch data for the given ID
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt_fetch = $conn->prepare("SELECT * FROM drivers WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $driver = $result_fetch->fetch_assoc();
    $stmt_fetch->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Driver</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Update Driver</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $driver['name'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $driver['email'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $driver['phone'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="license_number">License Number:</label>
                    <input type="text" class="form-control" id="license_number" name="license_number" value="<?php echo $driver['license_number'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $driver['address'] ?? ''; ?>">
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Update Driver</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
