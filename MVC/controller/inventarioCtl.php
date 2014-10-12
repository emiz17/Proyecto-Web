<?php
	class InventarioCtl {
		private $model;
		
		public function execute(){
			require_once("model/InventarioMdl.php");
			$this->model=new InventarioMdl();
			$act=isset($_GET['act'])?$_GET['act']:"";
			switch($act){
				case "alta":
					if(empty($_POST)){
						if($this->model->connection_successful())
							require_once("view/IngresaDatos.php");
					}//fin del if
					else{
					    //Obtener las variables para la alta
					    //y limpiarlas

						$res=TRUE;	

					    $vin = isset($_POST["vin"])?($_POST["vin"]!=="")?$_POST["vin"]:$res=FALSE:$res=FALSE;
					    $marca = isset($_POST["kilometraje"])?($_POST["kilometraje"]!=="")?$_POST["kilometraje"]:$res=FALSE:$res=FALSE;
						$modelo = isset($_POST["combustible"])?($_POST["combustible"]!=="")?$_POST["combustible"]:$res=FALSE:$res=FALSE;
						
						addslashes($vin);
						addslashes($kilometraje);
						addslashes($combustible);

						if ($res) {
							$resultado = $this -> model -> alta($vin, $kilometraje, $combustible);
							if($resultado!==FALSE){
							    require_once("view/AddInventario.php");
							}else{
								require_once("view/ErrorOperacion.php");
							}//fin del if($resultado!==FALSE)
						}else{
							require_once("view/ErrorOperacion.php");
						}//fin del if ($res)
					}//fin del primer else
				break;
				case "modificar":
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful())
							require_once("view/InsertVIN.php");
					}//fin del if
					else{
						//se buscara el vehiculo por VIN
						$vin = $_POST["vin"];
						addslashes($vin);
						
						//Se muestran los datos actuales
						$result=$this -> model -> mostrarDatos($vin);

						if ($result!==FALSE) {
							require_once("view/ShowInventario.php");
							echo "<br><br>Inserte el/los campos a modificar:<br>";
						}else{
							require_once("view/ErrorOperacion.php");
							echo "<br>";
							require_once("view/InsertVIN.php");
						}


						if ($result!==NULL) {			
							if(!empty($_POST['kilometraje'])||!empty($_POST['combustible'])){
								//Se escribiran de nuevo los datos insertados
								$kilometraje = isset($_POST["kilometraje"])?$_POST["kilometraje"]:$result['kilometraje'];
								$combustible = isset($_POST["combustible"])?$_POST["combustible"]:$result['combustible'];

								addslashes($kilometraje);
								addslashes($combustible);

								$result=$this -> model -> modificar($vin, $kilometraje, $combustible);
								if($result!==FALSE){
								    require_once("view/ModifyInventario.php");
								}
								else{
									require_once("view/ErrorOperacion.php");
								}//fin del else del if($result!==FALSE)

							}//fin del if(!empty($_POST['marca'])||...

						}//fin del if ($result!==NULL)
						
					}//fin del else del if(empty($_POST))
				break;
				case "mostrar":
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful())
							require_once("view/InsertVIN.php");
					}//fin del if
					else{
						
						$vin = isset($_POST["vin"])?$_POST["vin"]!==""?$_POST["vin"]:FALSE:FALSE;
						addslashes($vin);
						//se checara en la bd si el vin esta registrado y de ser asi
						//del vin se extraera la informacion del auto y se mostrara
						//esto es en lo que se obtiene exactamente lo que significa el contenido del vin
						//despues se contara con un diccionario 
						//para saber que dato nos proporciona el vin y mostrarlos

						//Si esta seteado el VIN, busca el VIN en la BD
						if ($vin!==FALSE) {				
							$result=$this -> model -> mostrarDatos($vin);

							//Si existe el VIN, muestralo, si no, manda error
							if($result!==FALSE){
								require_once("view/ShowInventario.php");
							}else{
								require_once("view/ErrorOperacion.php");
								echo "<br>";
								require_once("view/InsertVIN.php");
							}

						}else{//Si no esta seteado el VIN
							require_once("view/ErrorOperacion.php");
							echo "<br>";
							require_once("view/InsertVIN.php");
						}//fin del if ($vin!==FALSE)

					}//fin de else
				break;
				case "mostrarTodos":
					//despues se contara con un diccionario 
					//para saber que dato nos proporciona el vin y mostrarlos
					if($this->model->connection_successful()){
						$result= $this -> model -> mostrarTodos();
						if ($result!==FALSE) {			
							require_once("view/ShowTodosInventario.php");
						}else{
							require_once("view/ErrorOperacion.php");
						}
					}
				break;
				default:
					require_once("view/Default.php");
			}
		}
	
	}

?>