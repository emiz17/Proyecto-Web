<?php
$logout=new LogoutCtl();
$logout->logout();

Class LogoutCtl{

function logout(){
	session_start();
	session_unset();
	session_destroy();
	setcookie(session_name(), '', time()-3600);
	echo '<a href="/MVC/index.php">Clic para regresar al index</a>';
}
}
?>
