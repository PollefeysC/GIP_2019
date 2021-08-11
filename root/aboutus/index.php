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

<?php include("../en/design/nav.php") ?>


<?php 

$file = "../documents/Businessplan.pdf";
$filename = "Businessplan.pdf";
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="'.$filename.'"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
@readfile($file);

?>


<?php include("../en/design/footer.html")?>


<?php include("../en/design/login.php") ?>

</body>
</html>