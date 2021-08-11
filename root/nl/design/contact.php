<form id="contactform" method="POST" action="confirmation.php">
    <h1>
        Hebt u een vraag?
    </h1>
    <h3>Naam</h3>
    <input type="text" placeholder="Name" name="supportName"
    <?php 
        if (isset($_SESSION["name"])) {
            echo " value='".$_SESSION["name"]."' ";
        }
    ?>
    >
    <h3>Uw Email</h3>
    <input text="text" placeholder="Email" name="supportEmail"
    <?php 
        if (isset($_SESSION["email"])) {
            echo " value='".$_SESSION["email"]."' ";
        }
    ?>
    >
    <h3>Uw Vraag</h3>
    <textarea placeholder="Uw Vraag..." name="supportInfo"></textarea>
    <input type="submit" name="contactsubmit" value="Stuur Ons Uw Vraag" id="contactbutton">
</form>