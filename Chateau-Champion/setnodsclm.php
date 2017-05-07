<?php
session_start();
$ok = (isset($_GET["e"])?$_GET["e"]:"ok");
$_SESSION["nodisclaimer"]=$ok;
return true;
?>