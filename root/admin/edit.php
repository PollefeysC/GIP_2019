<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/master.css">
    <link rel="stylesheet" type="text/css" href="../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <script src="../js/scrollnav.js"></script>
    <script src="../js/loginpop.js"></script>
</head>
<body>

<?php include("../connection/connection.php") ?>

<?php 
if (isset($_POST['confirmedit'])) {
    $productID = $_POST['productID'];
    $name = $_POST['name'];
    $beschrijving = $_POST['beschrijving'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);
    
    } else {
        $sql = "UPDATE `product` SET `name` = '$name', `beschrijving` = '$beschrijving', `price` = '$price', `category` = '$category' WHERE `product`.`product_id` = '$productID';";

        $qresult = $connect1->query($sql);
    }

    header("Location: ../admin");
}
?>

<?php include("../en/design/nav.php") ?>

<form class='admin' id='editform' name='editremove' method='POST'>
<h2>Edit product</h2>

<?php 
if ($connect1->connect_error) {
    die("Connection failed: ".$connect1->connect_error);

} else {
    $productID = $_GET['productID'];
    $sql = "SELECT product.*, category.c_name FROM product INNER JOIN category ON category.category_id = product.category WHERE product.product_id = $productID;";

    $qresult = $connect1->query($sql);

    if ($qresult->num_rows > 0) {
        while ($endresult = $qresult->fetch_assoc()) {
            echo "
            <h3>Name</h3>
            <input id='invisproduct_id' name='productID' value='".$endresult['product_id']."'>
            <input class'editinput' name='name' value='".$endresult['name']."'>
            <h3>Description</h3>
            <input class'editinput' name='beschrijving' value='".$endresult['beschrijving']."'>
            <h3>Price</h3>
            <input type='number' step='0.01' min='0.01' class'editinput' name='price' value='".$endresult['price']."'>
            <h3>Category (1=Shorts / 2=Shirts / 3=Balls / 4=Rackets / 5=Bags / 6=Shoes)</h3>
            <input min='1' step='1' max='6' type='number' class'editinput' name='category' value='".$endresult['category']."'>
            <input type='submit' value='Confirm Edit' name='confirmedit' id='confirmedit'>
            ";
        }
    }
}







?>

</form>



<?php include("../en/design/footer.html")?>


<?php include("../en/design/login.php") ?>

</body>
</html>