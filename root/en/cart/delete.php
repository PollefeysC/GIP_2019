<?php 
session_start();

if (isset($_GET["delete"])) {
    $productID = $_GET["delete"];
    $customerID = $_SESSION["customer"];
    $sql = "DELETE FROM `cart` WHERE cart.productID = $productID AND cart.customerID = $customerID";


    include("../../connection/connection.php");

    if ($_SESSION["login"]) {
        if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);

    } else {
        $qresult = $connect1->query($sql);
    
}
}
header("Location: ../cart");
}

?>