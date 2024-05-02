<?php
require_once "header.php";
require_once "sidenav.php";

// Fetch list of income types
$stmt_income_types = $conn->prepare("SELECT id, name FROM income_type");
$stmt_income_types->execute();
$result_income_types = $stmt_income_types->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $income_type_id = $_POST["income_type_id"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $income_date = $_POST["income_date"];

    // Insert the income details into the income_details table
    $stmt_insert = $conn->prepare("INSERT INTO income_details (income_type_id, amount, description, income_date) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("idss", $income_type_id, $amount, $description, $income_date);

    if ($stmt_insert->execute()) {
        $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Income details added successfully</p>";
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
                <h1 class="page-header">Add New Income Details</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Add Income Details</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="income_type_id">Income Type:</label>
                    <select class="form-control" id="income_type_id" name="income_type_id" required>
                        <?php while ($row = $result_income_types->fetch_assoc()) { ?>
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
                    <label for="income_date">Income Date:</label>
                    <input type="date" class="form-control" id="income_date" name="income_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Income Details</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
