<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div id="overlay">
    <div id="popup">
    <form method="POST" name="form" id="loginform">
        <table id="logintable">
            <img src="../../img/pegasusBLAUWSVG.svg" id="pegasuslogin">

            <tr>
                <td><input type="text" placeholder="E-mail" name="login"> </td>
            </tr>

            <tr>
                <td><input type="password" placeholder="Mot de passe" name="password"></td>
            </tr>

            <tr>
                <td><input type="submit" id="submit" name="sendlogin" value="LOGIN"></td>
            </tr>

            <tr>
                <td id="registreertd"> Pas encore d'account? <a href="#" onclick="changeToSignup()">Inscrivez-vous!</a> </td>
            </tr>
            <tr>
                <td id="registreertd"> Oubli&eacute; mot de passe? <a href="../register/recover.php">Envoyer Recovery Mail</a> </td>
            </tr>

        </table>
    </form>

    <form method="POST" name="form" id="registerform">
        <table id="registertable">

            <tr>
                <td><input type="text" placeholder="Nom" name="regFullName" class="registerField regFullName" id="fullNameReg"> </td>
            </tr>

            <tr>
                <td><input type="text" placeholder="Rue" name="regStreet" class="registerField regStreet" id="streetReg">
                <input type="text" placeholder="Num&eacute;ro" name="regNumber" class="registerField regNumber" id="numberReg">
                <input type="text" placeholder="Code Postal" name="regPostalCode" class="registerField regPostalCode" id="PostalCodeReg"> </td>
            </tr>

            <tr>
                <td><input type="email" placeholder="E-mail" name="regEmail" class="registerField regEmail" id="emailReg">
            </tr>

            <tr>
                <td><input type="password" placeholder="Mot de passe" name="regPassword" class="registerField regPassword" id="passwordReg">
            </tr>

            <tr>
                <td><div class="g-recaptcha" name="captcha" data-sitekey="6LfBOpsUAAAAAHjI559-OivyHhgi60zSVcCinqA1"></div></td>
            </tr>

            <tr>
                <td><input type="submit" id="submit" name="sendsignup" value="Inscrivez-vous" class="registerField"></td>
            </tr>

            <tr>
                <td id="logintd"> Utilisateur existant? <a href="#" onclick="changeToLogin()">Login!</a> </td>
            </tr>

        </table>
    </form>

        <span id="xknop" onclick="closeLogin()">+</span>
    </div>
</div>

<?php

if (isset($_POST["sendsignup"])) {
    $isCorrect = true;
    $errorMsg = "";

    if (empty($_POST["regFullName"])) {
        $errorMsg .= "nom | ";
    }

    if (empty($_POST["regStreet"]) || empty($_POST["regNumber"]) || empty($_POST["regPostalCode"])) {
        $errorMsg .= "adresse | ";
    }

    if (empty($_POST["regEmail"])) {
        $errorMsg .= "email | ";
    }

    if (empty($_POST["regPassword"])) {
        $errorMsg .= "mot de passe | ";
    }

    if (empty($_POST["g-recaptcha-response"])) {
        $errorMsg .= "captcha | ";
    }
}

?>

<?php 

if (isset($_POST["sendsignup"])) {
    if (!empty($errorMsg)) {
        echo "<script> alert('Vous avez commis les erreurs suivantes lors de votre inscription: ".$errorMsg."');</script>";
    } else {
        //check of user al bestaat
        if ($connect1->connect_error) {
            die("Connection failed: ".$connect1->connect_error);
        
        } else {
            $email = $_POST["regEmail"];
            $sql = "SELECT * FROM `customer` WHERE `email` LIKE '$email'";       
            $qresult = $connect1->query($sql);
        }
        
        if ($qresult->num_rows > 0) {
            echo "<script> alert('Cet email a deja un compte attache;'); </script>";
        } else {
            //maak account aan
            $name = $_POST["regFullName"];
            $street = strtolower($_POST["regStreet"]);
            $streetnumber = $_POST["regNumber"];
            $postalcode = $_POST["regPostalCode"];
            $email = strtolower($_POST["regEmail"]);
            $password = md5($_POST["regPassword"]);
            $verification = md5($_POST["regPassword"].$_POST["regEmail"]);
            sendMail($name, $verification);
            
            $sql2 = "INSERT INTO `customer` (`customer_id`, `name`, `street`, `street_number`, `postal_code`, `email`, `password`, `verification_key`, `verified`) VALUES (NULL, '$name', '$street', '$streetnumber', '$postalcode', '$email', '$password', '$verification', 0);";
            
            $qresult2 = $connect1->query($sql2);
        }
    }
}

if (isset($_POST["sendlogin"]) && !isset($_SESSION['login'])) {
    $loginemail = strtolower($_POST["login"]);
    $loginpassword = md5($_POST["password"]);
    
    $sql3 = "SELECT * FROM `customer` WHERE `email` LIKE '$loginemail' AND `password` LIKE '$loginpassword'";
    $qresult3 = $connect1->query($sql3);

    if ($qresult3->num_rows > 0) {
        while ($endresult = $qresult3->fetch_assoc()) {
            if ($endresult["verified"] == 1) {
                $_SESSION["name"] = $endresult["name"];
                $_SESSION["customer"] = $endresult["customer_id"];
                $_SESSION["email"] = $endresult["email"];
                $_SESSION["street"] = $endresult["street"];
                $_SESSION["streetNumber"] = $endresult["street_number"];
                $_SESSION["postalCode"] = $endresult["postal_code"];
            
                $_SESSION["login"] = true;
                echo "<script>location.reload();</script>";
            } else {
                echo "<script> alert('Cet email ne est pas encore verifie.'); </script>";
            }
        }
    } else {
        echo "<script> alert('Cette combination de email et mot de passe ne existe pas.'); </script>";
    }
}


function sendMail($reg_name, $reg_code){
    echo "<script> alert('Email est en coure de route...'); </script>";

    date_default_timezone_set("Europe/Brussels"); 
    ini_set("SMTP","smtp.telenet.be" );  // vul als argumenten de juiste parameters van je provider in
    ini_set('sendmail_from', 'pegasus.tt@telenet.be'); // vul hier je mailadres in dat je als account van je provider hebt gekregen
    $ontvanger = "cedric@pollefeys.me";  // vul hier je eigen emailadres in, om zeker te zijn dat jij de mail ontvangt
    $reg_site = "http://localhost:8080/fr/register";
    $onderwerp = "Pegasus TT: votre compte";
    $bericht = "Merci pour votre registration \n\n";
    $bericht .= "Votre nom est: $reg_name\n";
    $bericht .= "Votre code de verification est: $reg_code\n";
    $bericht .= "Veuillez copier et coller ce code dans le champ sur le lien suivant: ".$reg_site ."\n";
    $bericht .= "Ou suivez ce lien direct: ".$reg_site."/?verification_key=".$reg_code;
    mail($ontvanger, $onderwerp, $bericht);
}

?>