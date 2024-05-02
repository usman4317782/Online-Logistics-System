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
    $driver_id = $_POST["driver_id"];
    $vehicle_id = $_POST["vehicle_id"];
    $starting_point = $_POST["starting_point"];
    $destination = $_POST["destination"];
    $distance_covered = $_POST["distance_covered"];
    $charges = $_POST["charges"];
    $trip_date = $_POST["trip_date"];

    // Insert the trip details into the trips table
    $stmt = $conn->prepare("INSERT INTO trips (driver_id, vehicle_id, starting_point, destination, distance_covered, charges, trip_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssds", $driver_id, $vehicle_id, $starting_point, $destination, $distance_covered, $charges, $trip_date);

    if ($stmt->execute()) {
        $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>New Trip added successfully </p>";
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
                <h1 class="page-header">Add New Trip</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Trip</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="driver_id">Driver:</label>
                    <select class="form-control" id="driver_id" name="driver_id" required>
                        <?php while ($row = $result_drivers->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="vehicle_id">Vehicle:</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                        <?php while ($row = $result_vehicles->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['registration_number']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="starting_point">Starting Point:</label>
                    <input type="text" class="form-control" id="starting_point" name="starting_point" required>
                </div>
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" class="form-control" id="destination" name="destination" required>
                </div>
                <div class="form-group">
                    <label for="distance_covered">Distance Covered:</label>
                    <input type="number" class="form-control" id="distance_covered" name="distance_covered" required>
                </div>
                <div class="form-group">
                    <label for="charges">Charges:</label>
                    <input type="number" class="form-control" id="charges" name="charges" required>
                </div>
                <div class="form-group">
                    <label for="trip_date">Trip Date:</label>
                    <input type="date" class="form-control" id="trip_date" name="trip_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Trip</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>