<?php
require_once "header.php";
require_once "sidenav.php";

// Fetch list of expense types
$stmt_expense_types = $conn->prepare("SELECT id, name FROM expense_type");
$stmt_expense_types->execute();
$result_expense_types = $stmt_expense_types->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_type_id = $_POST["expense_type_id"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $expense_date = $_POST["expense_date"];

    // Insert the expense details into the expense_details table
    $stmt_insert = $conn->prepare("INSERT INTO expense_details (expense_type_id, amount, description, expense_date) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("idss", $expense_type_id, $amount, $description, $expense_date);

    if ($stmt_insert->execute()) {
        $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Expense details added successfully</p>";
    } else {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: " . $stmt_insert->error . "</p>";
    }

    $stmt_insert->close();
}

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add New Expense Details</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Expense Details</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="expense_type_id">Expense Type:</label>
                    <select class="form-control" id="expense_type_id" name="expense_type_id" required>
                        <?php while ($row = $result_expense_types->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="text" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="expense_date">Expense Date:</label>
                    <input type="date" class="form-control" id="expense_date" name="expense_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Expense Details</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
