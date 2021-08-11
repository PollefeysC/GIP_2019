<?php
session_start();
include("../../connection/connection.php");

if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $customerID = $_SESSION["customer"];
    $productID = $_POST["productID"];
    $sql = "SELECT product.*, cart.* FROM product INNER JOIN cart ON product.product_id = cart.productID WHERE cart.customerID = $customerID AND cart.productID = $productID;";
    $qresult = $connect1->query($sql);
}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {
            $customerID = $_SESSION["customer"];
            $productID = $_POST["productID"];
            $sqlupdate = "UPDATE `cart` SET `amount` = amount + 1 WHERE cart.customerID = $customerID AND cart.productID = $productID AND amount < 9;";
            $connect1->query($sqlupdate);
    }
} else {
        $customerID = $_SESSION["customer"];
        $productID = $_POST["productID"];
        $sql = "INSERT INTO `cart` (`customerID`, `productID`, `amount`) VALUES ('$customerID', '$productID', 1);";
        $qresult = $connect1->query($sql);
}
header("Location: ../cart");

?>