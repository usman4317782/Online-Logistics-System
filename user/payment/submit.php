<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.replace('../sign-in.php');</script>";
}
?>
<?php
require_once "../db_connect.php";
?>
<?php
require('config.php');
// if(isset($_POST['stripeToken'])){
// 	\Stripe\Stripe::setVerifySslCerts(false);

// 	$token=$_POST['stripeToken'];

// 	$data=\Stripe\Charge::create(array(
// 		// "amount"=>1000,
// 		"amount"=>$_SESSION['amount'],
// 		"currency"=>"pkr",
// 		// "description"=>"Programming with Vishal Desc",
// 		"description"=>$_SESSION['description'],
// 		"source"=>$token,
// 	));

// 	echo "<pre>";
// 	print_r($data);
// }

if(isset($_POST['stripeToken'])){
    \Stripe\Stripe::setVerifySslCerts(false);

    $token=$_POST['stripeToken'];

    $data=\Stripe\Charge::create(array(
        // "amount"=>1000,
        "amount"=>$_SESSION['amount'],
        "currency"=>"pkr",
        // "description"=>"Programming with Vishal Desc",
        "description"=>$_SESSION['description'],
        "source"=>$token,
    ));

    // Extract necessary data from Stripe charge object
    $user_name = $_SESSION['username'];
    $logistics_rates_id = $_SESSION['logistics_rate_id'];
    $amount = $data->amount ; // Convert amount from cents to PKR
    $trans_id = $data->id;

    // Store data into logistics_booking table
    $stmt = $conn->prepare("INSERT INTO logistics_booking (user_name, logistics_rates_id, amount, trans_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sids", $user_name, $logistics_rates_id, $amount, $trans_id);
    if ($stmt->execute()) {
        // Booking data successfully inserted into the database
        echo "<p style='font-weight:bold; font-size: 25px; color:green;'>Booking successful. Trans ID: " . $trans_id.'</p>';
		echo "<script>setTimeout(function(){ window.location.replace('../logistics-rate-list.php'); }, 2000);</script>";

    } else {
        // Error inserting booking data
        echo "<p style='font-weight:bold; font-size: 12px; color:red;'>Error: " . $stmt->error.'</p>';
    }
    $stmt->close();
}
