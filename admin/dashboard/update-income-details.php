<?php
require_once "header.php";
require_once "sidenav.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $income_type_id = $_POST["income_type_id"];
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $income_date = $_POST["income_date"];

    // Check if any other income detail with the same income type ID exists
    $stmt_check = $conn->prepare("SELECT id FROM income_details WHERE income_type_id = ? AND id != ?");
    $stmt_check->bind_param("ii", $income_type_id, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $msg = "<p class='text text-center text-danger font-weight-bold mt-2 mb-1'>Error: Another income detail with the same income type ID already exists</p>";
    } else {
        // Update the income detail in the income_details table
        $stmt = $conn->prepare("UPDATE income_details SET income_type_id = ?, amount = ?, description = ?, income_date = ? WHERE id = ?");
        $stmt->bind_param("idssi", $income_type_id, $amount, $description, $income_date, $id);

        if ($stmt->execute()) {
            $msg = "<p class='text text-center text-success font-weight-bold mt-2 mb-1'>Income detail updated successfully</p>";
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
    $stmt_fetch = $conn->prepare("SELECT * FROM income_details WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $income_detail = $result_fetch->fetch_assoc();
    $stmt_fetch->close();
}

// Fetch list of income types
$stmt_income_types = $conn->prepare("SELECT id, name FROM income_type");
$stmt_income_types->execute();
$result_income_types = $stmt_income_types->get_result();

$conn->close();
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Update Income Detail</h1>
            </div>
        </div>
        <div class="container">
            <?php echo $msg ?? ""?>
            <h2>Update Income Detail</h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="income_type_id">Income Type:</label>
                    <select class="form-control" id="income_type_id" name="income_type_id" required>
                        <?php while ($row = $result_income_types->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $income_detail['income_type_id']) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?php echo $income_detail['amount'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $income_detail['description'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="income_date">Income Date:</label>
                    <input type="date" class="form-control" id="income_date" name="income_date" value="<?php echo $income_detail['income_date'] ?? "" ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Income Detail</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>