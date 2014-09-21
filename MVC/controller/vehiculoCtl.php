<?php
Class VehiculoCtl{
	private $modelo;

	public function execute(){
		require_once("model/VehiculoMdl.php");
		$this -> modelo = new VehiculoMdl();
		switch ($_GET['act']){
			case "alta":
				if(empty($_POST)){
					require_once("view/IngresaDatos.php");
				}
				else{
				    //Obtener las variables para la alta
				    //y limpiarlas
				    $vin = $_POST["vin"];
				    $marca = $_POST["marca"];
					$modelo = $_POST["modelo"];
					$color = $_POST["color"];

					addslashes($vin);
					addslashes($marca);
					addslashes($modelo);
					addslashes($color);

					$resultado = $this -> modelo -> alta($vin, $marca, $modelo, $color);
					if($resultado!==FALSE){
					    require_once("view/AddVehiculo.php");
					}
					else
						require_once("view/ErrorOperacion.php");
					}
			break;
			case "mostrar":
				if(empty($_POST)){
					//Cargo la vista de agrega datos
					require_once("view/IngresaDatos.php");
				}
				else{
					$vin = $_POST["vin"];
					addslashes($vin);
					list($vin, $marca, $modelo, $color) = $this -> modelo -> mostrarDatos($vin);
					require_once("view/ShowVehiculo.php");
				}
				break;
				case "mostrarTodos":
					list($vin, $marca, $modelo, $color) = $this -> modelo -> mostrarTodos();
					require_once("view/ShowVehiculo.php");
				break;
				case "eliminar":
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						require_once("view/IngresaDatos.php");
					}
					else{
						$vin = $_POST["vin"];
						addslashes($vin);
						$resultado = $this -> modelo -> eliminar($vin);
						if($resultado!==FALSE){
							require_once("view/VehiculoEliminado.php");
						}
						else
							equire_once("view/ErrorOperacion.php");
					}
				break;
				default:
					require_once("view/Default.php");
			}
		}
}

?>