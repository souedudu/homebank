<?php 
// Destrui��o da se��o.
session_start();

session_unset();
session_destroy();

header("location:index.php");
?>