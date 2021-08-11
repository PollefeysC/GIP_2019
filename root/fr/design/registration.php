<?php

if (isset($_GET["verification_key"])) {
    //code als de key geweten is
    if ($connect1->connect_error) {
        die("Connection failed: ".$connect1->connect_error);
    
    } else {
        $key = $_GET["verification_key"];
        $sql = "UPDATE `customer` SET `verified` = '1' WHERE `customer`.`verification_key` = '$key'";

        if ($connect1->query($sql) === TRUE) {
            echo "<h2>Votre code est correcte!";
            echo " Login!</h2>";
        } else {
            echo "<h2>Probleme: " . $connect1->error . "</h2>";
        }
    }
} else {
?>
    <h2>Veuillez copier votre code d'enregistrement ici</h2>
    <form method="GET" action="../register" id="registrationform">
        <input type="text" name="verification_key">
        <input type="submit" id="registrationsubmit" value='Finaliser'>
    </form>
    <?php
}

?>