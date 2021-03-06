<?php
	//url params:
	//ctl -> vehiculos, inventario, ubicacion
	//act -> alta, mostrar, mostrarTodos, eliminar(Solo para vehiculo)
	//echo $mostrar;
	$sesion=0;
	session_start();
	require_once("controller/sesionesCtl.php");
	$comprueba= new SesionesCtl();
	$comprueba->comprobarSesion();
	$ctl=isset($_GET['ctl'])?$_GET['ctl']:"";
	switch($ctl){
		case "vehiculo":
			require_once("controller/vehiculoCtl.php");
			$obj= new VehiculoCtl();
			$mostrar="";
		break;
		case "inventario":
			require_once("controller/inventarioCtl.php");
			$obj=new InventarioCtl();
		break;
		case "golpe":
			require_once("controller/golpeCtl.php");
			$obj=new GolpeCtl();
		break;
		case "ubicacion":
			require_once("controller/ubicacionCtl.php");
			$obj=new UbicacionCtl();
		break;
		case "usuario":
			require_once("controller/usuarioCtl.php");
			$obj=new UsuarioCtl();
		break;
		case "cliente":
			require_once("controller/clienteCtl.php");
			$obj=new ClienteCtl();
		break;
		case "empleado":
			require_once("controller/empleadoCtl.php");
			$obj=new EmpleadoCtl();	
		break;
		case "login":
			require_once("controller/loginCtl.php");
			$obj=new LoginCtl();
		break;
		default:
			$view=file_get_contents("index.html");
			echo $view;
			$obj=null;
	}
	

	if($obj!=null){
		$obj->execute();
	}

?>
