<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../../css/master.css">
    <link rel="stylesheet" type="text/css" href="../../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../../css/login.css">
    <link rel="stylesheet" type="text/css" href="../../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../../css/register.css">
    <script src="../../js/scrollnav.js"></script>
    <script src="../../js/loginpop.js"></script>
</head>
<body>

<?php include("../../connection/connection.php") ?>

<?php include("../design/nav.php") ?>

<?php

if (isset($_POST['newpassword']) && isset($_POST['customerID'])) {
    
    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);
    
    } else {
        $password = $_POST["newpassword"];
        $password = md5($password);
        $customerID = $_POST['customerID'];
        $sql = "UPDATE `customer` SET `password` = '$password' WHERE `customer`.`customer_id` = '$customerID'";

        if ($connect1->query($sql) === TRUE) {
            echo "<h2>Uw wachtwoord is aangepast!";
            echo " Je kan je nu aanmelden!</h2>";
        } else {
            echo "<h2>Foutmelding: " . $connect1->error . "</h2>";
        }
    }

} else {
    
    if (isset($_GET['customer_id']) && isset($_GET['key'])) {
    
        echo "
        
        <h2>Vul uw nieuwe wachtwoord in</h2>
        <form method='POST' action='../register/recover.php' id='registrationform'>
            <input type='password' name='newpassword'>
            <input type='text' name='customerID' id='inviscustomer' value='".$_GET['customer_id']."'>
            <input type='submit' id='registrationsubmit'>
        </form>
        
        ";
    
    } else {
    
    if (isset($_POST["email"])) {
        if ($connect1->connect_error) {
            die("Connection failed: ".$connect1->connect_error);
            
        } else {
            $recoveryEmail = $_POST["email"];
            $sql = "SELECT * FROM `customer` WHERE `email` LIKE '$recoveryEmail';";
            
            $qresult = $connect1->query($sql);
            if ($qresult->num_rows > 0) {
                while ($endresult = $qresult->fetch_assoc()) {
                    
                    $link = "http://".$_SERVER["HTTP_HOST"]."/en/register/recover.php?customer_id=".$endresult['customer_id']."&key=".$endresult['password'];
                    date_default_timezone_set("Europe/Brussels"); 
                    ini_set("SMTP","smtp.telenet.be" );  // vul als argumenten de juiste parameters van je provider in
                    ini_set('sendmail_from', 'pegasus.tt@telenet.be'); // vul hier je mailadres in dat je als account van je provider hebt gekregen
                    $ontvanger = "cedric@pollefeys.me";  // vul hier je eigen emailadres in, om zeker te zijn dat jij de mail ontvangt
                    $onderwerp = "Pegasus TT: herstel je wachtwoord";
                    $bericht = "Uw account vroeg om een wachtwoordreset. \n";
                    $bericht .= "Als u dit niet nodig heeft, mag u deze mail negeren. \n\n";
                    $bericht .= "Je kan je wachtwoord herstellen op volgende link: ".$link;

                    echo "<h2>We hebben u een herstelmail gestuurd</h2>";
    
                    mail($ontvanger, $onderwerp, $bericht);
                }
            }
        }
    } else {
        ?>
        <h2>Wat is uw email?</h2>
        <form method="POST" action="../register/recover.php" id="registrationform">
            <input type="text" name="email">
            <input type="submit" id="registrationsubmit">
        </form>
        <?php
    }
    }

}
?>

<?php include("../design/footer.html")?>

<?php include("../design/login.php") ?>

</body>
</html>