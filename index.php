<?php
require_once 'assets/php/functions.php';

if(isset($_GET['signup'])){
showPage("header",["page_title" => "Pictogram-Signup"]);
showPage("signup");
}

echo "Sessions";
p($_SESSION);
echo "post";
p($_POST);

showPage("footer");
unset($_SESSION['error']);
unset($_SESSION['formdata']);



?>