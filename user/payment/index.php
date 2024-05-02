<?php
require('config.php');
?>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.replace('../sign-in.php');</script>";
}
?>
<?php
require_once "../db_connect.php";

// Fetch user data from users table
$username = $_SESSION['username'];
$userQuery = "SELECT * FROM users WHERE username = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("s", $username);
$userStmt->execute();
$userResult = $userStmt->get_result();

if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
} else {
    // Handle case where user data is not found
    exit("User data not found");
}
$userStmt->close();

// Fetch logistics rate data from logistics_rates table using the provided id
$id = $_GET['id'] ?? null;
if ($id) {
	$_SESSION['logistics_rate_id'] = $id;
    $logisticsQuery = "SELECT * FROM logistics_rates WHERE rate_id = ?";
    $logisticsStmt = $conn->prepare($logisticsQuery);
    $logisticsStmt->bind_param("i", $id);
    $logisticsStmt->execute();
    $logisticsResult = $logisticsStmt->get_result();

    if ($logisticsResult->num_rows > 0) {
        $logisticsData = $logisticsResult->fetch_assoc();
    } else {
        // Handle case where logistics rate data is not found
        exit("Logistics rate data not found");
    }
    $logisticsStmt->close();
} else {
    // Handle case where id is not provided in the URL
    exit("Logistics rate id not provided");
}
$_SESSION['amount'] = intval($logisticsData['amount']);
$_SESSION['description'] = $logisticsData['origin'] . ' to ' . $logisticsData['destination']; 
?>

<form action="submit.php" method="post">
	<script
		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		data-key="<?php echo $publishableKey?>"
		data-amount="<?php echo $logisticsData['amount'] *100; ?>"
		data-name="<?php echo $userData['name']; ?>"
		data-description="<?php echo $logisticsData['origin'] . ' to ' . $logisticsData['destination']; ?>"
		data-image="https://www.logostack.com/wp-content/uploads/designers/eclipse42/small-panda-01-600x420.jpg"
		data-currency="pkr"
		data-email="<?php echo $userData['email']; ?>"
	>
	</script>
</form>
