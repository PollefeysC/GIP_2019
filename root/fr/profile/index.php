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
<h2>Votre Profile</h2>
<h3>Nom</h3>
".$endresult['name']."
<h3>Adresse de livraison</h3>
<form action='update.php' method='post' name='form'>
<input type='text' onchange='form.submit()' name='street' placeholder='Rue' value='".$endresult['street']."'>
<input type='text' onchange='form.submit()' name='number' placeholder='Numero' value='".$endresult['street_number']."'>
<input type='text' onchange='form.submit()' name='postalcode' placeholder='Code Postal' value='".$endresult['postal_code']."'>
</form>
<h3>Langue S&eacute;lectionn&eacute;e</h3>";?>

<?php if (isset($_COOKIE['lang'])) {
    if ($_COOKIE['lang'] == "en") {
        echo "English";
    } elseif ($_COOKIE['lang'] == "fr") {
        echo "Fran&ccedil;ais";
    } else {
        echo "Nederlands";
    }
}?>
<h3>Recover votre mot de passe</h3>
<a href='../register/recover.php'>Password Recovery par email</a>
</div>
";<?php
    }
}

?>



<div class='profilebox2'>
    <h3> Historique des commandes</h3>
    
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

        <h4>Commande (ID:<?php echo $endresult['orderID']?>)</h4>
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
    echo "Historique vide!";
}

?>



</div>




</body>
</html>

<?php include("../design/footer.html") ?>
<?php include("../design/login.php") ?>