<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../css/master.css">
    <link rel="stylesheet" type="text/css" href="../../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" type="text/css" href="../../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../../css/homepage.css">
    <link rel="stylesheet" type="text/css" href="../../css/shop.css">
    <script src="../../js/scrollnav.js"></script>
    <script src="../../js/loginpop.js"></script>
</head>
<body>

<?php include("../../connection/connection.php") ?>

<?php include("../design/nav.php") ?>

<div id="content">

<?php 
if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $product_id = $_GET["product_id"];
    $sql = $sql = "SELECT * FROM `product` WHERE `product_id` = $product_id";
    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {
    
?>
<div id="productcontainer">
<div class="imagebig">
<?php 
    echo "<img src='../../img_products/".$endresult['image']."'>";
?>
</div>
<div class="productinfo">
<?php 
    echo "<h2>".$endresult['name']."</h2>";
    echo "<h4>&euro;".number_format($endresult["price"],2)."</h4>";
    echo "<p>".$endresult["beschrijving"]."</p>";
    if (isset($_SESSION["login"])) {

            echo "  <form action='script.php' method='POST'>
            <input type='text' name='productID' value='".$product_id."' id='invisProductID'>
            <input id='winkelwagenbutton' type='submit' value='+ Ajouter au panier'> <br>
            </form>";
    } else {
        echo "  <form action='script.php' method='POST'>
        <input type='text' name='productID' value='".$product_id."' id='invisProductID'>
        <input id='winkelwagenbutton' disabled='disabled' type='submit' value='+ Ajouter au panier'> <br>
        </form>
        <p id='red'>Ajouter au panier est seulement possible pour des comptes</p>
        ";
    }

    }
}

?>
</div>
</div>
</div>


</body>
</html>

<?php include("../design/footer.html") ?>
<?php include("../design/login.php") ?>