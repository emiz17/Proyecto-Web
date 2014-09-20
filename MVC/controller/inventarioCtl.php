<?php
	class InventarioCtl {
		private $model;
		
		public function execute(){
			require_once("model/inventarioMdl.php");
			$this->model=new InventarioMdl();
			switch($_GET['act']){
				case "alta":
					if(empty($_POST)){
						require_once("vista/altaInventario.php");
					}else{
						//Obtener las variables para la alta
					
						$kilometraje 		= $_POST["kilometraje"];
						$cantCombustible	= $_POST["cantComb"];
						$piezasGolpeadas 	= $_POST["piezasGolp"];
						$severidadGolpe 	= $_POST["severidadGolp"];
						
						$formatedModel=$this->model->alta($kilometraje, $cantCombustible, $piezasGolpeadas, $severidadGolpe);
						if($formatedModel!=false){
							require_once(view/mostrarInventario.php);
						}else{
							require_once(view/error.php);
						}
						
							
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