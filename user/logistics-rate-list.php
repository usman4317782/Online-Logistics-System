<?php
require_once "header.php";
require_once "sidenav.php";
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
                                    <a href='payment/index.php?id=<?php echo $row["rate_id"]; ?>' class='btn btn-primary'><i class='fa fa-truck'></i></a>
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