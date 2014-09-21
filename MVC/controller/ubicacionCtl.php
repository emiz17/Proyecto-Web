<?php
Class ubicacionCtl{
	private $modelo;
	//y realizar la validacion de las palabras

	public function execute(){
	    require_once("model/UbicacionMdl.php");
	    $this -> modelo = new UbicacionMdl();
	    switch ($_GET['act']){
			case "alta":
				if(empty($_POST)){
					require_once("view/IngresaDatos.php");
				}
				else{
					//Obtener las variables para la alta
					//y limpiarlas
					$vin = $_POST["vin"];
					$accion = $_POST["accion"];
					$motivo = $_POST["motivo"];
					$ubicacion = $_POST["ubicacion"];
					$fecha = $_POST["fecha"];
					$hora = $_POST["hora"];

  					addslashes($vin);
  					addslashes($accion);
  					addslashes($motivo);
  					addslashes($ubicacion);
  					addslashes($fecha);
  					addslashes($hora);

					$resultado = $this -> modelo -> alta($vin, $accion, $motivo, $ubicacion,$fecha,$hora);
					if($resultado!==FALSE){
					   require_once("view/AddUbicacion.php");
					}
					 else
					   require_once("view/ErrorOperacion.php");
				}
				break;
				case "mostrarUbicacion":
					if(empty($_POST)){
					   //Cargo la vista de agrega datos
					   require_once("view/IngresaDatos.php");
					}
					else{						
					   $vin = $_POST["vin"];
					   addslashes($vin);

					   $ubicacion = $this -> modelo -> mostrarUbicacion($vin);
					   require_once("view/ShowUbicacion.php");
					}
				break;
				case "mostrarUbicacionTodos":
					 list($vin, $ubicacion) = $this -> modelo -> mostrarUbicacionTodos();
					 require_once("view/ShowUbicacion.php");
				break;
				default:
					 require_once("view/Default.php");
			}
		}
}

?>