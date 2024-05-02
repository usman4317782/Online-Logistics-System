<?php
require_once "header.php";
require_once "sidenav.php";

// Check if form is submitted for status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id']) && isset($_POST['status'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    // Update status in the database
    $update_sql = "UPDATE logistics_booking SET status = ? WHERE booking_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $status, $booking_id);

    if ($update_stmt->execute()) {
        $msg = "Status updated successfully.";
    } else {
        $error_msg = "Error updating status: " . $update_stmt->error;
    }

    $update_stmt->close();
}

?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Booked Logistics</h1>
            </div>
        </div>
        <div class="container">
            <?php if (isset($msg)) : ?>
                <div class="alert alert-success"><?php echo $msg; ?></div>
            <?php endif; ?>
            <?php if (isset($error_msg)) : ?>
                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
            <?php endif; ?>
            <table id="logisticsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Booking Date</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Weight Range (Min)</th>
                        <th>Weight Range (Max)</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT lb.booking_id, lb.created_at AS booking_date, u.name, u.username, u.address, u.email, u.phone, lr.origin, lr.destination, lr.weight_range_min, lr.weight_range_max, lb.amount, lb.status
                            FROM logistics_booking lb
                            INNER JOIN logistics_rates lr ON lb.logistics_rates_id = lr.rate_id
                            INNER JOIN users u ON lb.user_name = u.username";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $count = 0;
                        while ($row = $result->fetch_assoc()) {
                            $count++;
                    ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row["username"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <td><?php echo $row["email"]; ?></td>
                                <td><?php echo $row["phone"]; ?></td>
                                <td><?php echo $row["booking_date"]; ?></td>
                                <td><?php echo $row["origin"]; ?></td>
                                <td><?php echo $row["destination"]; ?></td>
                                <td><?php echo $row["weight_range_min"]; ?></td>
                                <td><?php echo $row["weight_range_max"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="Under Process" <?php if ($row['status'] == 'Under Process') echo 'selected'; ?>>Under Process</option>
                                            <option value="Delivered" <?php if ($row['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                            <option value="Cancelled" <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='14'>No booked logistics found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
