<H1>INDEX</H1>

<H4>Vehiculos | Inventario | Ubicacion</H4>

<?php
	//url params:
	//ctl -> vehiculos, inventario, ubicacion
	//act -> alta, baja, vista
	$ctl=isset($_GET['ctl'])?$_GET['ctl']:"";
	switch($ctl){
		case "vehiculos":
			require_once("controller/vehiculoCtl.php");
			$ctl= new VehiculoCtl();
		break;
		case "inventario":
			require_once("controller/inventarioCtl.php");
			$ctl=new Inventario();
		break;
		case "ubicacion":
			require_once("controller/ubicacionCtl.php");
			$ctl=new Ubicacion();
		break;
		default:
			require_once("index.php");
	}
	
	$ctl->execute();
?>