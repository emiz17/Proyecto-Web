<H1>INDEX</H1>

<H4>Vehiculos | Inventario | Ubicacion | Golpes | Usuarios | Empleados | Clientes </H4>

<?php
	//url params:
	//ctl -> vehiculos, inventario, ubicacion
	//act -> alta, mostrar, mostrarTodos, eliminar(Solo para vehiculo)
	$sesion=0;
	session_start();
	require_once("controller/sesionesCtl.php");
	$comprueba= new SesionesCtl();
	$comprueba->comprobarSesion();
	$ctl=isset($_GET['ctl'])?$_GET['ctl']:"";
	switch($ctl){
		case "vehiculos":
			require_once("controller/vehiculoCtl.php");
			$obj= new VehiculoCtl();
		break;
		case "inventario":
			require_once("controller/inventarioCtl.php");
			$obj=new InventarioCtl();
		break;
		case "golpes":
			require_once("controller/golpeCtl.php");
			$obj=new GolpeCtl();
		break;
		case "ubicacion":
			require_once("controller/ubicacionCtl.php");
			$obj=new UbicacionCtl();
		break;
		default:
			require_once("view/Default.php");
			$obj=null;
	}
	

	if($obj!=null)
		$obj->execute();

?>
