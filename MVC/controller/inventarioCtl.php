<?php
	class InventarioCtl {
		private $model;
		
		public function execute(){
			require_once("model/inventarioMdl.php");
			$this->modelo=new InventarioMdl();
			switch($_GET['act']){
				case "alta":
					if(empty($_POST)){
						require_once("vista/altaInventario.php");
					}else{
						//Obtener las variables para la alta
						//y limpiarlas
						$kilometraje 		= $_POST["kilometraje"];
						$cantCombustible	= $_POST["cantComb"];
						$piezasGolpeadas 	= $_POST["piezasGolp"];
						$severidadGolpe 	= $_POST["severidadGolp"];

					}
				break;
				case "baja":
				break;
				case "modificar":
				break;
				default:
					//enviar vista de error
			}
		}
	
	}

?>