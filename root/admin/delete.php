<?php 
session_start();

if (isset($_GET["productID"])) {
    $productID = $_GET["productID"];
    $sql = "DELETE FROM `product` WHERE product.product_id = $productID;";


    include("../connection/connection.php");

    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);

    } else {
        $file = $_GET['img'];
        $path = "../img_products/".$file;
        unlink($path);
        $qresult = $connect1->query($sql);
    }

header("Location: ../admin");
}

?>