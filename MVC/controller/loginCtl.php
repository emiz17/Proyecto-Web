<?php
$usuario= $_GET['usuario'];
$pass= $_GET['pass'];
$login=new LoginCtl();
$login->login($usuario, $pass);

Class LoginCtl{

function login($usuario, $pass){
	session_start();
	$_SESSION['usuario'] = $usuario;
	$_SESSION['clave'] = $pass;
	echo '<a href="/MVC/index.php">Clic para regresar al index</a>';
}

}
?>
