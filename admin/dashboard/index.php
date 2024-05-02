<?php
require_once "header.php";
require_once "sidenav.php";

// Define icons for each table
$table_icons = array(
    "users" => "fa-comments",
    "drivers" => "fa-tasks",
    "logistics_rates" => "fa-shopping-cart",
    "expense_type" => "fa-support",
    "income_type" => "fa-truck",
    "trips" => "fa-road",
    "vehicles" => "fa-car"
);

// Define labels for each table
$table_labels = array(
    "users" => "Users",
    "drivers" => "Drivers",
    "logistics_rates" => "Logistics Rates",
    "expense_type" => "Expense Types",
    "income_type" => "Income Types",
    "trips" => "Trips",
    "vehicles" => "Vehicles"
);

// Define panel colors for each category
$category_colors = array(
    "users" => "panel-primary",
    "drivers" => "panel-green",
    "logistics_rates" => "panel-yellow",
    "expense_type" => "panel-red",
    "income_type" => "panel-blue",
    "trips" => "panel-orange",
    "vehicles" => "panel-purple"
);

?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col">
                <h1>
                    Admin Dashboard
                </h1>
                <hr>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            // Iterate over each table
            foreach ($table_icons as $table => $icon) {
                // Fetch count of records for the current table
                $sql = "SELECT COUNT(*) AS count FROM $table";
                $result = $conn->query($sql);
                $count = $result->fetch_assoc()['count'];
            ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel <?php echo $category_colors[$table]; ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa <?php echo $icon; ?> fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count; ?></div>
                                    <div><?php echo $table_labels[$table]; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo $table; ?>.php">
                            <div class="panel-footer">
                                <!-- <span class="pull-left">View Details</span> -->
                                <!-- <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div> -->
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
