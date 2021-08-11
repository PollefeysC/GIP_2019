<?php session_start();
$cookie_name = "lang";
$cookie_value = "fr";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../css/master.css">
    <link rel="stylesheet" type="text/css" href="../../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" type="text/css" href="../../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../../css/homepage.css">
    <script src="../../js/scrollnav.js"></script>
    <script src="../../js/loginpop.js"></script>
</head>
<body>

<?php include("../../connection/connection.php") ?>

<?php include("../design/nav.php") ?>

<?php 
if (isset($_SESSION["justSentSupport"])) {
    if ($_SESSION["justSentSupport"]) {
        echo "<script> alert('Merci pour nous contacter!'); </script>";
        $_SESSION["justSentSupport"] = false;
    }
}
?>

<div id='wallpaper'>
    <img src='../../img/ttwallpaper.jpg' id='wallpaper'>
    <h1 id='slogan'>reach new heights</h1>
    <h3 id='slogan2'>pegasus tt</h3>
</div>

<div id='container'>
    <a href='../shop'>
    <div class='topAd' id='store'>
        magasin
    </div>
    </a>
    <a href='../shop/?filtercategory=1&submitfilter=FILTER&minPrice=0&maxPrice=999'>
    <div class='ad' id='shorts'>
        shorts
    </div>
    </a>
    <a href='../shop/?filtercategory=2&submitfilter=FILTER&minPrice=0&maxPrice=999'>
    <div class='ad' id='shirts'>
        maillots
    </div>
    </a>
    <a href='../shop/?filtercategory=3&submitfilter=FILTER&minPrice=0&maxPrice=999'>
    <div class='ad' id='balls'>
        balles
    </div>
    </a>
    <a href='../shop/?filtercategory=4&submitfilter=FILTER&minPrice=0&maxPrice=999'>
    <div class='ad' id='rackets'>
        raquettes
    </div>
    </a>
    <a href='../shop/?filtercategory=5&submitfilter=FILTER&minPrice=0&maxPrice=999'>
    <div class='ad' id='bags'>
        sacs
    </div>
    </a>
    <a href='../shop/?filtercategory=6&submitfilter=FILTER&minPrice=0&maxPrice=999'>
    <div class='ad' id='shoes'>
        chaussures
    </div>
    </a>
</div>

<?php include("../design/footer.html")?>

<?php include("../design/login.php") ?>

</body>
</html>