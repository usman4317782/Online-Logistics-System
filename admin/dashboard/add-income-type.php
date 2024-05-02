<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];

    // Check if the income type already exists
    $stmt_check = $conn->prepare("SELECT id FROM income_type WHERE name = ?");
    $stmt_check->bind_param("s", $name);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Income type already exists!</p>";
    } else {
        // Insert the income type into the income_type table
        $stmt_insert = $conn->prepare("INSERT INTO income_type (name) VALUES (?)");
        $stmt_insert->bind_param("s", $name);

        if ($stmt_insert->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>New income type added successfully</p>";
        } else {
            $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt_insert->error . "</p>";
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Income Type</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Income Type</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Income Type</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
