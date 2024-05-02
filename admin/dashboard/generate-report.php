<?php
require_once "header.php";
require_once "sidenav.php";

?>
<style>
    .report {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    /* Define print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .report,
        .report * {
            visibility: visible;
        }

        .report {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Generate Report</h1>
            </div>
        </div>
        <div class="container">
            <form method="post">
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <button type="submit" class="btn btn-primary" name="generate_report">Generate Report</button>
            </form>

            <!-- Display Report Here -->
            <?php
            if (isset($_POST['generate_report'])) {
                // Include database connection

                // Retrieve form data
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                // Query to fetch income
                $sql_income = "SELECT SUM(amount) AS total_income FROM income_details WHERE income_date BETWEEN '$start_date' AND '$end_date'";
                $result_income = $conn->query($sql_income);
                $row_income = $result_income->fetch_assoc();
                $total_income = $row_income['total_income'];

                // Query to fetch expenses
                $sql_expense = "SELECT SUM(amount) AS total_expense FROM expense_details WHERE expense_date BETWEEN '$start_date' AND '$end_date'";
                $result_expense = $conn->query($sql_expense);
                $row_expense = $result_expense->fetch_assoc();
                $total_expense = $row_expense['total_expense'];

                // Calculate total
                $total = $total_income - $total_expense;

                // Close database connection
                $conn->close();

                // Display report
                echo "<br><div class='report'>";
                echo "<h3>Report</h3>";
                echo "<p><strong>Start Date:</strong> $start_date</p>";
                echo "<p><strong>End Date:</strong> $end_date</p>";
                echo "<p><strong>Total Income:</strong> $total_income</p>";
                echo "<p><strong>Total Expense:</strong> $total_expense</p>";
                echo "<p><strong>Total:</strong> $total</p>";
                echo "</div>";
                echo "<script>window.print()</script>";
            }
            ?>

        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>