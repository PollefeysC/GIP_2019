<header>
        <a href="../home"><img src="../../img/pegasusWITSVG.svg" id="logo"></a>
        <input type="checkbox" id="nav-checker">
        <nav>
            <ul>
                <li><a href="../home">Accueil</a></li>
                <li><a href="../shop/">Magasin</a></li>
                <?php
                if (isset($_SESSION["login"])) {
                    if ($_SESSION["login"]) {
                        echo "
                        <li>
                        <a href='../cart'><img src='../../img/shopping-cart.svg' id='logo2'>";
                        
                        if ($connect1->connect_error) {
                            die("Connection failed: ".$connect1->connect_error);
                        
                        } else {
                            $customer = $_SESSION["customer"];
                            $sql = "SELECT product.*, cart.* FROM product INNER JOIN cart ON product.product_id = cart.productID WHERE cart.customerID = $customer;";
                            $qresult = $connect1->query($sql);
                            
                            if ($qresult->num_rows > 0) {
                                $_SESSION["numberInCart"] = $qresult->num_rows;
                                if ($qresult->num_rows > 9) {
                                    echo "<span id='numberInCart'>9+</span>";
                                } else {
                                    echo "<span id='numberInCart'>".$_SESSION["numberInCart"]."</span>";
                                }
                            }
                        }
                        
                        echo "
                        </a>
                        </li>

                        <li>
                        <a href='../profile'><img src='../../img/man-user.svg' id='logo2'></a>
                        </li>


                        <li>
                        <form id='form-id' method='POST' action='#'>
                        <input type='submit' value='log out' name='submitlogout' id='submitlogout'></input>
                        </form>
                        </li>
                        ";
                    } else {
                        echo "<li><a href='#' onclick='openLogin();'>Login</a></li>";
                    }
                } else {
                    echo "<li><a href='#' onclick='openLogin();'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
        <label for="nav-checker" id="nav-checker-hamburger">
            <span></span>
        </label>
</header>

<?php 

if (isset($_POST["submitlogout"])) {
    $_SESSION["login"] = false;
    session_destroy();
    header("Refresh: 0");
}

?>