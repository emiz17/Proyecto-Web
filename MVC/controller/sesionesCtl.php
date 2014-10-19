<?php

Class SesionesCtl{

function comprobarSesion(){
if(isset($_SESSION['usuario'])){
	$usuario=$_SESSION['usuario'] ;
	echo "Ya tienes sesion $usuario <br>";
	echo '<br><a href="controller/logout.php">Cerrar sesion </a>';
}
else{
	echo 'Necesitas ingresar al sistema <br>';
	echo '<a href="controller/login.php?u=pedro&t=ge">Clic para hacer login</a>';
}
}

function isLogged(){
if( isset($_SESSION['user']) )
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
