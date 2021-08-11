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
                <td><input type="password" placeholder="Password" name="password"></td>
            </tr>

            <tr>
                <td><input type="submit" id="submit" name="sendlogin" value="Login"></td>
            </tr>

            <tr>
                <td id="registreertd"> No account? <a href="#" onclick="changeToSignup()">Sign up!</a> </td>
            </tr>
            <tr>
                <td id="registreertd"> Forgot Password? <a href="../register/recover.php">Send Recovery Mail</a> </td>
            </tr>

        </table>
    </form>

    <form method="POST" name="form" id="registerform">
        <table id="registertable">

            <tr>
                <td><input type="text" placeholder="Full name" name="regFullName" class="registerField regFullName" id="fullNameReg"> </td>
            </tr>

            <tr>
                <td><input type="text" placeholder="Street" name="regStreet" class="registerField regStreet" id="streetReg">
                <input type="text" placeholder="Number" name="regNumber" class="registerField regNumber" id="numberReg">
                <input type="text" placeholder="Postal Code" name="regPostalCode" class="registerField regPostalCode" id="PostalCodeReg"> </td>
            </tr>

            <tr>
                <td><input type="email" placeholder="E-mail" name="regEmail" class="registerField regEmail" id="emailReg">
            </tr>

            <tr>
                <td><input type="password" placeholder="Password" name="regPassword" class="registerField regPassword" id="passwordReg">
            </tr>

            <tr>
                <td><div class="g-recaptcha" name="captcha" data-sitekey="6LfBOpsUAAAAAHjI559-OivyHhgi60zSVcCinqA1"></div></td>
            </tr>

            <tr>
                <td><input type="submit" id="submit" name="sendsignup" value="SIGN UP" class="registerField"></td>
            </tr>

            <tr>
                <td id="logintd"> Existing user? <a href="#" onclick="changeToLogin()">Log in!</a> </td>
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
        $errorMsg .= "full name | ";
    }

    if (empty($_POST["regStreet"]) || empty($_POST["regNumber"]) || empty($_POST["regPostalCode"])) {
        $errorMsg .= "address | ";
    }

    if (empty($_POST["regEmail"])) {
        $errorMsg .= "email | ";
    }

    if (empty($_POST["regPassword"])) {
        $errorMsg .= "password | ";
    }

    if (empty($_POST["g-recaptcha-response"])) {
        $errorMsg .= "captcha | ";
    }
}

?>

<?php 

if (isset($_POST["sendsignup"])) {
    if (!empty($errorMsg)) {
        echo "<script> alert('You made the following mistakes in your registration: ".$errorMsg."');</script>";
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
            echo "<script> alert('This email already has an account attached to it'); </script>";
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
                echo "<script> alert('This email is not yet verified.'); </script>";
            }
        }
    } else {
        echo "<script> alert('This combination of email and password does not exist.'); </script>";
    }
}


function sendMail($reg_name, $reg_code){
    echo "<script> alert('Email is being sent... Please check your mailbox to continue registration'); </script>";

    date_default_timezone_set("Europe/Brussels"); 
    ini_set("SMTP","smtp.telenet.be" );  // vul als argumenten de juiste parameters van je provider in
    ini_set('sendmail_from', 'pegasus.tt@telenet.be'); // vul hier je mailadres in dat je als account van je provider hebt gekregen
    $ontvanger = "cedric@pollefeys.me";  // vul hier je eigen emailadres in, om zeker te zijn dat jij de mail ontvangt
    $reg_site = "http://localhost:8080/en/register";
    $onderwerp = "Pegasus TT: activate your account";
    $bericht = "Thank you for your registration \n\n";
    $bericht .= "Your registration name is: $reg_name\n";
    $bericht .= "Your verificationcode is: $reg_code\n";
    $bericht .= "Please copy and paste this code in the field on following link : ".$reg_site ."\n";
    $bericht .= "Or click this direct link: ".$reg_site."/?verification_key=".$reg_code;
    mail($ontvanger, $onderwerp, $bericht);
}

?>