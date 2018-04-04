<?php
if(isset($_POST['lang']) AND ($_POST['lang'] == "fr" OR $_POST['lang'] == "en"))
{
setcookie('language', $_POST['lang'], time() + 365*24*3600, null, null, false, true); // On écrit un cookie
$cookie = $_POST['lang'];
}

echo json_encode(['cookie' => $cookie]);

?>