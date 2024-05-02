<?php
require_once "header.php";
require_once "sidenav.php";

// Fetch list of expense types
$stmt_expense_types = $conn->prepare("SELECT id, name FROM expense_type");
$stmt_expense_types->execute();
$result_expense_types = $stmt_expense_types->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];

    // Check if the updated name already exists for another expense type
    $stmt_check = $conn->prepare("SELECT id FROM expense_type WHERE name = ? AND id != ?");
    $stmt_check->bind_param("si", $name, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: The updated expense type name already exists for another expense type</p>";
    } else {
        // Update the expense type details in the expense_type table
        $stmt = $conn->prepare("UPDATE expense_type SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $id);

        if ($stmt->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Expense type updated successfully</p>";
        } else {
            $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    $stmt_check->close();
}

// Fetch data for the given ID
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt_fetch = $conn->prepare("SELECT * FROM expense_type WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $expense_type = $result_fetch->fetch_assoc();
    $stmt_fetch->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Expense Type</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Update Expense Type</h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $expense_type['name'] ?? ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Expense Type</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
