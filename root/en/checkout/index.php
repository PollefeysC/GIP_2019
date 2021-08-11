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

<?php include("../design/nav.php") ?>

<div id="content">

<?php 
    $total = 0;
    $totalamount = 0;

if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $customer = $_SESSION["customer"];
    $sql = "SELECT product.*, cart.* FROM product INNER JOIN cart ON product.product_id = cart.productID WHERE cart.customerID = $customer;";
    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    echo "<div id='cartcheckout' class='checkoutbox'>
    <h3>Shopping Cart</h3>";

    while ($endresult = $qresult->fetch_assoc()) {
    $total = $total + $endresult["price"] * $endresult["amount"];
    $totalamount = $totalamount + $endresult['amount'];
?>

<?php 
    echo "
    
    &#183; ".$endresult["name"]." <span>x".$endresult["amount"]."</span>
    
    <br>";
?>

<?php 
    }
    echo "<hr>
    
    Total of all products: <span>&euro;".number_format($total,2)."</span>
    
    <br>
    ";

    if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $sql2 = "SELECT discount.* FROM discount WHERE discount.code = '$code';";
            $qresult2 = $connect1->query($sql2);
        
        if ($qresult2->num_rows > 0) {
            while ($endresult = $qresult2->fetch_assoc()) {
                echo "<br>Code ".$endresult['code']."<span id='gratis'>- &euro;".number_format($endresult['discount'],2)."</span><br>";
                $total = $total - $endresult['discount'];
                if ($total < 0) {
                    $total = 0;
                }
            }
        } else {
            echo "<form name='form' method='GET'><input onchange='form.submit()' placeholder='Discount Code' type='text' id='code' name='code'></form>";
        }
        
    } else {
        echo "<form name='form' method='GET'><input onchange='form.submit()' placeholder='Discount Code' type='text' id='code' name='code'></form>";
    }
    
    echo "
    <br>
    
    Delivery Fee:
    ";
    if ($total >= 50) {
        echo "<span id='gratis'>Free</span>";
    } else {
        echo "<span>&euro;4.99</span>";
        $total = $total + 4.99;
    }
    echo "
    
    <hr>

    Final Price: <span>&euro;".number_format($total,2)."</span>

    ";?>
</div>
<div id='confirmcheckout' class='checkoutbox'>
<h3>Checkout Confirmation</h3>
<h4>Shipping Address:</h4>
<?php 
    echo $_SESSION['name']."<br>";
    echo $_SESSION['street']." ".$_SESSION['streetNumber']."<br>";
    echo $_SESSION['postalCode'].", Belgium";
?>
<h4>Cost:</h4>
<?php 
    echo "&euro;".number_format($total,2);
?>
<br>
<form name='form' action='paid.php' method='POST'>
    <input type='submit' name='paid' id='pay' value='Pay'>
    <input type='text' name='total' id='invisprice' value='<?php echo $total;?>'>
</form>
</div>

<?php 
} else {
    echo "<h1>You don't have any products in your shopping cart</h1>";
}

?>


</div>
<?php include("../design/footer.html")?>

<?php include("../design/login.php") ?>

</body>
</html>