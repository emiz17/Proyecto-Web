<?php
$usuario= $_GET['usuario'];
$pass= $_GET['pass'];
$login=new LoginCtl();
$login->login($usuario, $pass);

Class LoginCtl{

function login($usuario, $pass){
	require_once("model/UsuarioMdl.php");
	$this -> model = new UsuarioMdl();
	$result=$this -> model->existeUsuario($usuario,$pass);
	if($result===true){
		session_start();
		$_SESSION['usuario'] = $usuario;
		$_SESSION['clave'] = $pass;
		$_SESSION['type'] =$this -> model->obtenerTipo($usuario);
		echo '<a href="/MVC/index.php">Clic para regresar al index</a>';
	}
	else{
		echo "Usuario o Password incorrectos<br>";
		echo '<a href="/MVC/index.php">Clic para regresar al index</a>';
	}

}

/*

require_once("model/UsuarioMdl.php");
	$this -> model = new UsuarioMdl();
	$usuario=$_SESSION['usuario'] ;
	$result=$this -> model->existeUsuario($usuario);
	if($result===true){
		echo "Ya tienes sesion $usuario <br>";
		$_SESSION['type'] =$this -> model->obtenerTipo($usuario);
	}
*/
}
?>
