<?php
require_once "header.php";
require_once "sidenav.php";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.replace('../sign-in.php');</script>";
    exit; // Stop further execution
}

// Get the username of the logged-in user
$username = $_SESSION['username'];

?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Book Logistics</h1>
            </div>
            <?php echo $msg ?? "";?>
        </div>
        <div class="container">
            <table id="logisticsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
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
                    // SQL query to fetch booked logistics for the logged-in user
                    $sql = "SELECT lb.created_at AS booking_date, lr.origin, lr.destination, lr.weight_range_min, lr.weight_range_max, lb.amount, lb.status
                            FROM logistics_booking lb
                            INNER JOIN logistics_rates lr ON lb.logistics_rates_id = lr.rate_id
                            WHERE lb.user_name = ?";
                    
                    // Prepare and execute the statement
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $count = 0;
                        while ($row = $result->fetch_assoc()) {
                            $count++;
                            $status = $row['status'] == '' ? 'Under Process' : $row['status'];
                    ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row["booking_date"]; ?></td>
                                <td><?php echo $row["origin"]; ?></td>
                                <td><?php echo $row["destination"]; ?></td>
                                <td><?php echo $row["weight_range_min"]; ?></td>
                                <td><?php echo $row["weight_range_max"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td><?php echo $status; ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8'>No booked logistics found</td></tr>";
                    }
                    // Close statement and connection
                    $stmt->close();
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
