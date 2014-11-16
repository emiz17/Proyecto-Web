<?php

	Class SesionesCtl{

		function comprobarSesion(){
			if(isset($_SESSION['usuario'])){
				$usuario=$_SESSION['usuario'] ;
				$mensaje="Ya tienes sesion $usuario <br><br><a href=\"controller/logoutCtl.php\">Cerrar sesion </a>";
				//echo $mensaje;
			}
			else{
				$mensaje="Necesitas ingresar al sistema <br><a href=\"controller/loginCtl.php?usuario=pedro&pass=ge\">Clic para hacer login</a>";
				//echo $mensaje;
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

	}//fin de clase
?>
