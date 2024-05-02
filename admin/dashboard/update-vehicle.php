<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $registration_number = $_POST["registration_number"];
    $color = $_POST["color"];

    // Check if the registration number already exists for another record
    $stmt_check = $conn->prepare("SELECT * FROM vehicles WHERE registration_number = ? AND id <> ?");
    $stmt_check->bind_param("si", $registration_number, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Registration number already exists for another record!</p>";
    } else {
        // Update the vehicle record if registration number is unique
        $stmt = $conn->prepare("UPDATE vehicles SET model = ?, year = ?, registration_number = ?, color = ? WHERE id = ?");
        $stmt->bind_param("sissi", $model, $year, $registration_number, $color, $id);

        if ($stmt->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Vehicle record updated successfully</p>";
        } else {
            $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $stmt_check->close();
}

// Fetch data for the given ID
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt_fetch = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $vehicle = $result_fetch->fetch_assoc();
    $stmt_fetch->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Vehicle</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Update Vehicle</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="model">Model:</label>
                    <input type="text" class="form-control" id="model" name="model" value="<?php echo $vehicle['model'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" class="form-control" id="year" name="year" value="<?php echo $vehicle['year'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="registration_number">Registration Number:</label>
                    <input type="text" class="form-control" id="registration_number" name="registration_number" value="<?php echo $vehicle['registration_number'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <input type="text" class="form-control" id="color" name="color" value="<?php echo $vehicle['color'] ?? ''; ?>">
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary">Update Vehicle</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
