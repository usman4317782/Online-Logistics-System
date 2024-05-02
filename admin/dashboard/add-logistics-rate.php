<?php
require_once "header.php";
require_once "sidenav.php";

// Fetch list of registered drivers
$stmt_drivers = $conn->prepare("SELECT id, name FROM drivers");
$stmt_drivers->execute();
$result_drivers = $stmt_drivers->get_result();

// Fetch list of registered vehicles
$stmt_vehicles = $conn->prepare("SELECT id, registration_number FROM vehicles");
$stmt_vehicles->execute();
$result_vehicles = $stmt_vehicles->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origin = $_POST["origin"];
    $destination = $_POST["destination"];
    $weight_range_min = $_POST["weight_range_min"];
    $weight_range_max = $_POST["weight_range_max"];
    $amount = $_POST["amount"];

    // Insert the logistics rates into the logistics_rates table
    $stmt = $conn->prepare("INSERT INTO logistics_rates (origin, destination, weight_range_min, weight_range_max, amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddd", $origin, $destination, $weight_range_min, $weight_range_max, $amount);

    if ($stmt->execute()) {
        $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>New Logistics Rate added successfully</p>";
    } else {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Logistics Rate</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Logistics Rate</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="origin">Origin (From where start):</label>
                    <input type="text" class="form-control" id="origin" name="origin" required>
                </div>
                <div class="form-group">
                    <label for="destination">Destination (From where end):</label>
                    <input type="text" class="form-control" id="destination" name="destination" required>
                </div>
                <div class="form-group">
                    <label for="weight_range_min">Weight Range (Min in KG):</label>
                    <input type="number" class="form-control" id="weight_range_min" name="weight_range_min" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="weight_range_max">Weight Range (Max in KG):</label>
                    <input type="number" class="form-control" id="weight_range_max" name="weight_range_max" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Logistics Rate</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
