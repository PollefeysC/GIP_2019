<form id="contactform" method="POST" action="confirmation.php">
    <h1>
        Besoin d'aide?
    </h1>
    <h3>Nom</h3>
    <input type="text" placeholder="Nom" name="supportName"
    <?php 
        if (isset($_SESSION["name"])) {
            echo " value='".$_SESSION["name"]."' ";
        }
    ?>
    >
    <h3>Votre Email</h3>
    <input text="text" placeholder="Email" name="supportEmail"
    <?php 
        if (isset($_SESSION["email"])) {
            echo " value='".$_SESSION["email"]."' ";
        }
    ?>
    >
    <h3>Votre Question</h3>
    <textarea placeholder="Votre Question..." name="supportInfo"></textarea>
    <input type="submit" name="contactsubmit" value="Envoyer Nous Votre Question" id="contactbutton">
</form>