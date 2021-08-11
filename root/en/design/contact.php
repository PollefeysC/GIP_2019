<form id="contactform" method="POST" action="confirmation.php">
    <h1>
        Need help?
    </h1>
    <h3>Full Name</h3>
    <input type="text" placeholder="Name" name="supportName"
    <?php 
        if (isset($_SESSION["name"])) {
            echo " value='".$_SESSION["name"]."' ";
        }
    ?>
    >
    <h3>Your Email</h3>
    <input text="text" placeholder="Email" name="supportEmail"
    <?php 
        if (isset($_SESSION["email"])) {
            echo " value='".$_SESSION["email"]."' ";
        }
    ?>
    >
    <h3>Your Question</h3>
    <textarea placeholder="Your Question..." name="supportInfo"></textarea>
    <input type="submit" name="contactsubmit" value="Send Us Your Question" id="contactbutton">
</form>