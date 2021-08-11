<?php
session_start(); 

sendSupportTicket($_POST["supportName"], $_POST["supportEmail"], $_POST["supportInfo"]);

function sendSupportTicket($name, $email, $ticketInfo){

    date_default_timezone_set("Europe/Brussels"); 
    ini_set("SMTP","smtp.telenet.be" );  // vul als argumenten de juiste parameters van je provider in
    ini_set('sendmail_from', 'pegasus.tt@telenet.be'); // vul hier je mailadres in dat je als account van je provider hebt gekregen
    $ontvanger = "cedric@pollefeys.me";  // vul hier je eigen emailadres in, om zeker te zijn dat jij de mail ontvangt
    $onderwerp = "Ticket de support";
    $bericht = "Nom: $name\n";
    $bericht .= "Email: $email\n\n";
    $bericht .= "Question: $ticketInfo\n";
    mail($ontvanger, $onderwerp, $bericht);
    $_SESSION["justSentSupport"] = true;

    header('Location: ../home');
}

?>