<?php 
session_start();
include("../../connection/connection.php"); ?>


<?php
if (!isset($_POST['street'])) {
    header("Location: ../profile");
}

if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $customer = $_SESSION["customer"];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $postalcode = $_POST['postalcode'];
    $_SESSION['streetnumber'] = $number;
    $_SESSION['street'] = $street;
    $_SESSION['postalCode'] = $postalcode;
    $sql = "UPDATE `customer` SET `street` = '$street', `street_number` = '$number', `postal_code` = '$postalcode' WHERE customer_id = $customer;";    
    $qresult = $connect1->query($sql);
    header("Location: ../profile");
}

?>