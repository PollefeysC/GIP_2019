<?php session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../home");
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../css/master.css">
    <link rel="stylesheet" type="text/css" href="../../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" type="text/css" href="../../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../../css/cart.css">
    <script src="../../js/scrollnav.js"></script>
    <script src="../../js/loginpop.js"></script>
</head>
<body>

<?php include("../../connection/connection.php") ?>

<?php 
if (isset($_POST['paid']) && isset($_POST['total'])) {


    /* move shopping cart over to permanent order */

    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);
    
    } else {
        $customer = $_SESSION["customer"];
        $sql3 = "SELECT product.*, cart.* FROM product INNER JOIN cart ON product.product_id = cart.productID WHERE cart.customerID = $customer;";
        $qresult3 = $connect1->query($sql3);
        if ($qresult3->num_rows > 0) {

            $total = $_POST['total'];
            $customer = $_SESSION['customer'];
            date_default_timezone_set("CET");
            $timestamp = date("Y-m-d H:i:s");
            $sql2 = "INSERT INTO `order` (orderID,customerID,paidPrice,date) VALUES (NULL, '$customer', '$total', '$timestamp');";
            if ($connect1->connect_error) {
                die("Connection failed: ".$connect1->connect_error);
            
            } else {
                $qresult2 = $connect1->query($sql2);
        
                $sqlLastOrder = "SELECT `orderID` FROM `order` ORDER BY `orderID`;";
                $lastOrderQuery = $connect1->query($sqlLastOrder);
                if ($lastOrderQuery->num_rows > 0) {
                    while ($endresult = $lastOrderQuery->fetch_assoc()) {
                        $lastOrderID = $endresult['orderID'];
                    }
                }
            }


            while ($endresult = $qresult3->fetch_assoc()) {
                $productID = $endresult['productID'];
                $amount = $endresult['amount'];

                $sql4 = "INSERT INTO `orderitem` (`order_id`, `productID`, `amount`) VALUES ('$lastOrderID', '$productID', '$amount');";
                if ($connect1->connect_error) {
                    die("Connection failed: ".$connect1->connect_error);
                
                } else {
                    $qresult4 = $connect1->query($sql4);
                }
            }
        } else {
            echo "nope";
        }
    }
}
?>


<?php 
if (isset($_POST['paid']) && isset($_POST['total'])) {

    $customer = $_SESSION['customer'];
    $sql = "DELETE FROM `cart` WHERE `customerID` = $customer";

    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);
    
    } else {
        $qresult = $connect1->query($sql);
        include("../design/nav.php");
        echo "<h3 id='auth'>Bedankt voor je aankoop! Je bestelling is goed ontvangen</h3>";
    }

} else {
    include("../design/nav.php");
    echo "<h3 id='nonauth'>Non-authenticated request, keer alstublieft terug naar check out</h3>";
}

?>


<?php include("../design/footer.html")?>

<?php include("../design/login.php") ?>

</body>
</html>