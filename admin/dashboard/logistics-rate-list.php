<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && $_GET['action'] === 'delete')  {
    $id = $_GET["id"];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM logistics_rates WHERE rate_id = ?");

    // Bind parameters
    $stmt->bind_param("i", $id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the page showing all booked logistics
        $msg = "<p class='text text-center text-success font-weight-bold'>Success! Record deleted successfully</p>";
        echo "<script>window.setTimeout(function () {
            location.href = 'logistics-rate-list.php';
        }, 1000);</script>";
    } else {
        // If deletion fails, display error message
        $msg = "<p class='text text-center text-danger font-weight-bold'>Error deleting record</p>: " . $stmt->error;
    }
}

?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Booked Logistics</h1>
            </div>
            <?php echo $msg ?? "";?>
        </div>
        <div class="container">
            <table id="logisticsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Weight Range (Min)</th>
                        <th>Weight Range (Max)</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM logistics_rates";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row["rate_id"]; ?></td>
                                <td><?php echo $row["origin"]; ?></td>
                                <td><?php echo $row["destination"]; ?></td>
                                <td><?php echo $row["weight_range_min"]; ?></td>
                                <td><?php echo $row["weight_range_max"]; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td>
                                    <a href='update-logistics-rate.php?id=<?php echo $row["rate_id"]; ?>' class='btn btn-primary'><i class='fa fa-pencil'></i></a>
                                    <a href='?id=<?php echo $row["rate_id"]; ?>&action=delete' class='btn btn-danger' onclick='return confirm("Are you sure you want to delete this record?");'><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No booked logistics found</td></tr>";
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