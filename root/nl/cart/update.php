<?php 
session_start();

include("../../connection/connection.php");

if (1==1) {
    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);
    
    } else {
        $customer = $_SESSION["customer"];
        $sql = "SELECT product.*, cart.* FROM product INNER JOIN cart ON product.product_id = cart.productID WHERE cart.customerID = $customer;";
        $qresult = $connect1->query($sql);
    
    }
    
    if ($qresult->num_rows > 0) {
        while ($endresult = $qresult->fetch_assoc()) {
            $amount = $_GET[$endresult['productID']];
            if ($amount < 1) {
                $amount = 1;
            }
            if ($amount > 9) {
                $amount = 9;
            }
            $product = $endresult['productID'];
            $sqlupdate = "UPDATE `cart` SET `amount` = $amount WHERE cart.customerID = $customer AND cart.productID = $product;";
            $qresultupdate = $connect1->query($sqlupdate);
        }
    }
}
header("Location: ../cart");

?>