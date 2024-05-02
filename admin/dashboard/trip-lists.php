<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && $_GET['action'] === 'delete')  {
    $id = $_GET["id"];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM trips WHERE id = ?");

    // Bind parameters
    $stmt->bind_param("i", $id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the page showing all registered vehicles
        $msg = "<p class='text text-center text-success font-weight-bold'>Success! Record deleted successfully</p>";
        echo "<script>window.setTimeout(function () {
            location.href = 'trip-lists.php';
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
                <h1 class="page-header">Trip Lists</h1>
            </div>
            <?php echo $msg ?? "";?>
        </div>
        <div class="container">
            <table id="tripTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Driver</th>
                        <th>Vehicle</th>
                        <th>Starting Point</th>
                        <th>Destination</th>
                        <th>Distance Covered</th>
                        <th>Charges</th>
                        <th>Trip Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT t.*, d.name AS driver_name, v.registration_number AS vehicle_registration 
                            FROM trips t
                            JOIN drivers d ON t.driver_id = d.id
                            JOIN vehicles v ON t.vehicle_id = v.id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["driver_name"]; ?></td>
                                <td><?php echo $row["vehicle_registration"]; ?></td>
                                <td><?php echo $row["starting_point"]; ?></td>
                                <td><?php echo $row["destination"]; ?></td>
                                <td><?php echo $row["distance_covered"]; ?></td>
                                <td><?php echo $row["charges"]; ?></td>
                                <td><?php echo $row["trip_date"]; ?></td>
                                <td>
                                    <a href='update-trip.php?id=<?php echo $row["id"]; ?>' class='btn btn-primary'><i class='fa fa-pencil'></i></a>
                                    <a href='?id=<?php echo $row["id"]; ?>&action=delete' class='btn btn-danger' onclick='return confirm("Are you sure you want to delete this record?");'><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='9'>No trips found</td></tr>";
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