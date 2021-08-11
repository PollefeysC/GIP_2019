<?php
if (isset($_COOKIE['lang'])) {
    if ($_COOKIE['lang'] == "nl") {
        header("Location: nl/home");
    } elseif ($_COOKIE['lang'] == "fr") {
        header("Location: fr/home");
    } else {
        header("Location: en/home");
    }
} else {
    header("Location: en/home");
}

?>