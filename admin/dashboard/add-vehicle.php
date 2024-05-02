<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST["model"];
    $year = $_POST["year"];
    $registration_number = $_POST["registration_number"];
    $color = $_POST["color"];

    // Check if the registration number already exists
    $stmt_check = $conn->prepare("SELECT * FROM vehicles WHERE registration_number = ?");
    $stmt_check->bind_param("s", $registration_number);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Registration number already exists!</p>";
    } else {
        // Insert the vehicle if registration number is unique
        $stmt = $conn->prepare("INSERT INTO vehicles (model, year, registration_number, color) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $model, $year, $registration_number, $color);

        if ($stmt->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>New Vehicle added successfully </p>";
        } else {
            $msg = "<p  class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: </p>" . $stmt->error;
        }

        $stmt->close();
    }

    $stmt_check->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Vehicle</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Vehicle</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" class="form-control" id="year" name="year" required>
                </div>
                <div class="form-group">
                    <label for="registration_number">Registration Number:</label>
                    <input type="text" class="form-control" id="registration_number" name="registration_number" required>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <input type="text" class="form-control" id="color" name="color">
                </div>
                <button type="submit" class="btn btn-primary">Add Vehicle</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>