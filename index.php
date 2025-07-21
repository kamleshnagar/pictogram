<?php
require_once 'assets/php/functions.php';



if (isset($_SESSION['AUTH'])) {
    echo "user logged in";
    echo "Sessions";
    p($_SESSION);
} elseif (isset($_GET['signup'])) {
    showPage("header", ["page_title" => "Pictogram-Signup"]);
    showPage("signup");
} elseif (isset($_GET['login'])) {
    showPage("header", ["page_title" => "Pictogram-Login"]);
    showPage("login");
} else {
    header('location:?login');
}


showPage("footer");
unset($_SESSION['error']);
unset($_SESSION['formdata']);
