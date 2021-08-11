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
if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $customer = $_SESSION["customer"];
    $sql = "SELECT product.*, cart.* FROM product INNER JOIN cart ON product.product_id = cart.productID WHERE cart.customerID = $customer;";
    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    $total = 0;
    echo "<div class='shoppingcart'>
    <form action='update.php' method='GET' name='form'>
    <table>
    <thead>
    <tr>
        <th>Produit</th>
        <th>Quantit&eacute;</th>
        <th>Prix</th>
    </tr>
    </thead>
    <tbody>";
    while ($endresult = $qresult->fetch_assoc()) {
    $total = $total + $endresult["price"] * $endresult["amount"];
?>

<?php 
    echo "

    <tr>
    <td><img id='cartimage' src='../../img_products/".$endresult['image']."'>".$endresult['name']."</td>
    <td><input onchange='form.submit();' step='1' name='".$endresult['productID']."' type='number' min='1' max='9' value='".$endresult['amount']."'> <a href='../cart/delete.php?delete=".$endresult["productID"]."' id='delete'>X</a> </td>
    <td>&euro;".number_format($endresult['price']*$endresult['amount'],2)."</td>
    </tr>

    ";
?>

<?php 
    }
    echo "</tbody>";
    echo "<tfoot>";
    echo "  <tr>
                <th colspan='2'>Total (livraison gratuite &agrave; partir de &euro;50)</th>
                <td>&euro;".number_format($total,2)."</td>
            </tr>
            <tr>
                <td colspan='3' id='checkouttd'><a id='checkout' href='../checkout'>Confirmer</a></td>
            </tr>
            
            
            
            ";
} else {
    echo "<h2>Vous n'avez aucun produit dans votre panier</h2>";
}

?>

</table>
</form>
</div>

<?php include("../design/footer.html")?>

<?php include("../design/login.php") ?>

</body>
</html>