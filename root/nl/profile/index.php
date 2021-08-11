<?php session_start();
if (!isset($_SESSION['customer'])) {
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
    <link rel="stylesheet" type="text/css" href="../../css/homepage.css">
    <link rel="stylesheet" type="text/css" href="../../css/profile.css">
    <script src="../../js/scrollnav.js"></script>
    <script src="../../js/loginpop.js"></script>
</head>
<body>

<?php include("../../connection/connection.php") ?>

<?php include("../design/nav.php") ?>
<?php

if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $customer = $_SESSION["customer"];
    $sql = "SELECT * FROM `customer` WHERE `customer_id` = $customer";
    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {
echo "
<div class='profilebox'>
<h2>Uw profiel</h2>
<h3>Naam</h3>
".$endresult['name']."
<h3>Verzendingsadres</h3>
<form action='update.php' method='post' name='form'>
<input type='text' onchange='form.submit()' name='street' placeholder='Street' value='".$endresult['street']."'>
<input type='text' onchange='form.submit()' name='number' placeholder='Number' value='".$endresult['street_number']."'>
<input type='text' onchange='form.submit()' name='postalcode' placeholder='Postal Code' value='".$endresult['postal_code']."'>
</form>
<h3>Geselecteerde Taal</h3>";?>

<?php if (isset($_COOKIE['lang'])) {
    if ($_COOKIE['lang'] == "en") {
        echo "English";
    } elseif ($_COOKIE['lang'] == "fr") {
        echo "Fran&ccedil;ais";
    } else {
        echo "Nederlands";
    }
}?>
<h3>Recover uw wachtwoord</h3>
<a href='../register/recover.php'>Wachtwoord Recovery via mail</a>
</div>
";<?php
    }
}

?>



<div class='profilebox2'>
    <h3>Bestelgeschiedenis</h3>
    
<?php

if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $customer = $_SESSION['customer'];
    $sql = "SELECT * FROM `order` WHERE `customerID` = $customer ORDER BY  `orderID` DESC";
    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {
        ?>
        <div class='order'>

        <h4>Bestelling (ID:<?php echo $endresult['orderID']?>)</h4>
        <h5>&euro;<?php echo $endresult['paidPrice']?> | <?php echo $endresult['date']?></h5>
        
        <?php 
        $orderID = $endresult['orderID'];
        $sql2 = "SELECT * FROM orderitem INNER JOIN product ON orderitem.productID = product.product_id WHERE `order_id` = $orderID";
        
        $qresult2 = $connect1->query($sql2);
    
        if ($qresult2->num_rows > 0) {
            while ($endresult = $qresult2->fetch_assoc()) {
                
                echo $endresult['amount']."x - ".$endresult['name']."<br>";

            }
        }
        
        
        
        
        
        
        ?>
        </div>
        <?php
    }
} else {
    echo "Lege geschiedenis! Koop iets :P";
}

?>



</div>




</body>
</html>

<?php include("../design/footer.html") ?>
<?php include("../design/login.php") ?>