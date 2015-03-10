<?php
session_start(); // me aseguro que estoy en la misma sesión
session_destroy(); // destruyo la sesión
header("location:index.php"); // redirigimos al inicio
exit();
?>
