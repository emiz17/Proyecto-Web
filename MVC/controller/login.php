<?php
session_start();
$_SESSION['usuario'] = $_GET['u'];
$_SESSION['type'] = $_GET['t'];
echo '<a href="/MVC/index.php">Clic para regresar al index</a>';
?>
