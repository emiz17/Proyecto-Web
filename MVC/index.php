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
			require_once("index.php");
			$obj=null;
	}
	

	if($obj!=null)
		$obj->execute();

?>