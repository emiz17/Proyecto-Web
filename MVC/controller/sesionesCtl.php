<?php

Class SesionesCtl{

function comprobarSesion(){
if(isset($_SESSION['usuario'])){
	$usuario=$_SESSION['usuario'] ;
	echo "Ya tienes sesion $usuario <br>";
	echo '<br><a href="controller/logoutCtl.php">Cerrar sesion </a>';
}
else{
	echo 'Necesitas ingresar al sistema <br>';
	echo '<a href="controller/loginCtl.php?usuario=pedro&pass=ge">Clic para hacer login</a>';
}
}

function isLogged(){
if( isset($_SESSION['usuario']) )
	return true;
return false;
}

function isAdmin(){
if( isset($_SESSION['type']) && $_SESSION['type'] == 'admin' )
	return true;
return false;
}

function isCliente(){
if( isset($_SESSION['type']) && $_SESSION['type'] == 'cliente' )
	return true;
return false;
}

function isEmpleado(){
if( isset($_SESSION['type']) && $_SESSION['type'] == 'empleado' )
	return true;
return false;
}

}
?>
