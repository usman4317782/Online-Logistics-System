<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $expense_type_id = $_POST["expense_type_id"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $expense_date = $_POST["expense_date"];

    // Check if any other expense detail with the same expense type ID exists
    $stmt_check = $conn->prepare("SELECT id FROM expense_details WHERE expense_type_id = ? AND id != ?");
    $stmt_check->bind_param("ii", $expense_type_id, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: Another expense detail with the same expense type ID already exists</p>";
    } else {
        // Update the expense detail in the expense_details table
        $stmt = $conn->prepare("UPDATE expense_details SET expense_type_id = ?, amount = ?, description = ?, expense_date = ? WHERE id = ?");
        $stmt->bind_param("idssi", $expense_type_id, $amount, $description, $expense_date, $id);

        if ($stmt->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Expense detail updated successfully</p>";
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
    $stmt_fetch = $conn->prepare("SELECT * FROM expense_details WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $expense_detail = $result_fetch->fetch_assoc();
    $stmt_fetch->close();
}

// Fetch list of expense types
$stmt_expense_types = $conn->prepare("SELECT id, name FROM expense_type");
$stmt_expense_types->execute();
$result_expense_types = $stmt_expense_types->get_result();

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Expense Detail</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Update Expense Detail</h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="expense_type_id">Expense Type:</label>
                    <select class="form-control" id="expense_type_id" name="expense_type_id" required>
                        <?php while ($row = $result_expense_types->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $expense_detail['expense_type_id']) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $expense_detail['amount'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $expense_detail['description'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="expense_date">Expense Date:</label>
                    <input type="date" class="form-control" id="expense_date" name="expense_date" value="<?php echo $expense_detail['expense_date'] ?? "" ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Expense Detail</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
