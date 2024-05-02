<?php
require_once "header.php";
require_once "sidenav.php";
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]) && $_GET['action'] === 'delete')  {
    $id = $_GET["id"];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM income_details WHERE id = ?");

    // Bind parameters
    $stmt->bind_param("i", $id);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to the page showing all income details
        $msg = "<p class='text text-center text-success font-weight-bold'>Success! Record deleted successfully</p>";
        echo "<script>window.setTimeout(function () {
            location.href = 'income-list.php';
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
                <h1 class="page-header">Income Details</h1>
            </div>
            <?php echo $msg ?? "";?>
        </div>
        <div class="container">
            <table id="incomeTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Income Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Income Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT id, income_type_id, amount, description, income_date FROM income_details";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Fetch income type name
                            $income_type_name = "";
                            $income_type_id = $row["income_type_id"];
                            $stmt_income_type = $conn->prepare("SELECT name FROM income_type WHERE id = ?");
                            $stmt_income_type->bind_param("i", $income_type_id);
                            $stmt_income_type->execute();
                            $stmt_income_type->bind_result($income_type_name);
                            $stmt_income_type->fetch();
                            $stmt_income_type->close();
                    ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $income_type_name; ?></td>
                                <td><?php echo $row["amount"]; ?></td>
                                <td><?php echo $row["description"]; ?></td>
                                <td><?php echo $row["income_date"]; ?></td>
                                <td>
                                    <a href='update-income-details.php?id=<?php echo $row["id"]; ?>' class='btn btn-primary'><i class='fa fa-pencil'></i></a>
                                    <a href='?id=<?php echo $row["id"]; ?>&action=delete' class='btn btn-danger' onclick='return confirm("Are you sure you want to delete this record?");'><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No income details found</td></tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
require_once "footer.php";
?>
