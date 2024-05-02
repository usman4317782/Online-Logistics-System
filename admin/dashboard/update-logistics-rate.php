<?php
require_once "header.php";
require_once "sidenav.php";

// Fetch data for the given ID
$id = $_GET['id'] ?? null;
if ($id) {
    // Prepare statement to fetch the record from logistics_rates table
    $stmt_fetch = $conn->prepare("SELECT * FROM logistics_rates WHERE rate_id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $logistics_rate = $result_fetch->fetch_assoc();
    $stmt_fetch->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $origin = $_POST["origin"];
    $destination = $_POST["destination"];
    $weight_range_min = $_POST["weight_range_min"];
    $weight_range_max = $_POST["weight_range_max"];
    $amount = $_POST["amount"];

    // Update the logistics rate details in the logistics_rates table
    $stmt = $conn->prepare("UPDATE logistics_rates SET origin = ?, destination = ?, weight_range_min = ?, weight_range_max = ?, amount = ? WHERE rate_id = ?");
    $stmt->bind_param("ssdddi", $origin, $destination, $weight_range_min, $weight_range_max, $amount, $id);

    if ($stmt->execute()) {
        $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Logistics rate updated successfully</p>";
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
                <h1 class="page-header">Update Logistics Rate</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Update Logistics Rate</h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="origin">Origin:</label>
                    <input type="text" class="form-control" id="origin" name="origin" value="<?php echo $logistics_rate['origin'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="destination">Destination:</label>
                    <input type="text" class="form-control" id="destination" name="destination" value="<?php echo $logistics_rate['destination'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="weight_range_min">Weight Range (Min):</label>
                    <input type="number" step="0.01" class="form-control" id="weight_range_min" name="weight_range_min" value="<?php echo $logistics_rate['weight_range_min'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="weight_range_max">Weight Range (Max):</label>
                    <input type="number" step="0.01" class="form-control" id="weight_range_max" name="weight_range_max" value="<?php echo $logistics_rate['weight_range_max'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?php echo $logistics_rate['amount'] ?? ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Logistics Rate</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
