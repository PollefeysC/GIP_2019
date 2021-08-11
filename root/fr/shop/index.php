<?php session_start(); ?>
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

<?php include("../design/floatingfilter.php") ?>

<div id="content">

<?php 
if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $sql = "SELECT product.*, category.c_name FROM product INNER JOIN category ON category.category_id = product.category;";

    if (isset($_GET["submitfilter"])) {

        $pickedcategory = $_GET["filtercategory"];
        $min = $_GET['minPrice'];
        $max = $_GET['maxPrice'];
        $sql = "SELECT product.*, category.c_name FROM product INNER JOIN category ON category.category_id = product.category WHERE product.category = $pickedcategory AND product.price BETWEEN $min AND $max;";
        if ($pickedcategory == 0) {
            $sql = "SELECT product.*, category.c_name FROM product INNER JOIN category ON category.category_id = product.category WHERE product.price BETWEEN $min AND $max;";
        }

}

    $qresult = $connect1->query($sql);

}

if ($qresult->num_rows > 0) {
    while ($endresult = $qresult->fetch_assoc()) {
    
?>
<a href="../product?product_id=<?php echo $endresult['product_id']?>">
<div class="product">
<div class="image">
<?php 
    echo "<img src='../../img_products/".$endresult['image']."' id='product'> 
</div>";
    echo "<h2>".$endresult['name']."</h2>";
    echo "<h4>&euro;".number_format($endresult["price"],2)."</h4>";
?>
</div>
</a>
<?php 
    }
}

?>

</div>


</body>
</html>

<?php include("../design/footer.html") ?>
<?php include("../design/login.php") ?>