<?php
Class VehiculoCtl{
	private $model;

	public function execute(){
		require_once("model/VehiculoMdl.php");
		$this -> model = new VehiculoMdl();
		$act=isset($_GET['act'])?$_GET['act']:"";
		switch ($act){
			case "alta":
				if(empty($_POST)){
					if($this->model->connection_successful())
						require_once("view/IngresaDatos.php");
				}//fin del if
				else{
				    //Obtener las variables para la alta
				    //y limpiarlas
				    //en lo que se obtiene exactamente lo que significa el contenido del vin
				    //de las siguientes se borraran la de marca y modelo menos la del color
					$res=TRUE;	

				    $vin = isset($_POST["vin"])?($_POST["vin"]!=="")?$_POST["vin"]:$res=FALSE:$res=FALSE;
				    $marca = isset($_POST["marca"])?($_POST["marca"]!=="")?$_POST["marca"]:$res=FALSE:$res=FALSE;
					$modelo = isset($_POST["modelo"])?($_POST["modelo"]!=="")?$_POST["modelo"]:$res=FALSE:$res=FALSE;
					$color = isset($_POST["color"])?($_POST["color"]!=="")?$_POST["color"]:$res=FALSE:$res=FALSE;

					addslashes($vin);
					addslashes($marca);
					addslashes($modelo);
					addslashes($color);

					//el vin se puede validar pero aun no se encuentra un estandar
  					//que usar-> 17 caracteres , cualquiera menos I,O,Q y Ñ
  					// primerods 3 son WMI
  					//sig 6 son VDS
  					//ultimos VIS
  					//basado en http://www.guiaautomotrizcr.com/Articulos/numero_VIN.php

					if ($res) {
						$resultado = $this -> model -> alta($vin, $marca, $modelo, $color);
						if($resultado!==FALSE){
						    require_once("view/AddVehiculo.php");
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

					if ($result!==NULL) {
						require_once("view/ShowVehiculo.php");
						echo "<br><br>Inserte el/los campos a modificar:<br>";
					}else{
						require_once("view/ErrorOperacion.php");
						echo "<br>";
						require_once("view/InsertVIN.php");
					}


					if ($result!==NULL) {			
						if(!empty($_POST['marca'])||!empty($_POST['modelo'])||!empty($_POST['color'])){
							//Se escribiran de nuevo los datos insertados
							$marca = isset($_POST["marca"])?$_POST["marca"]:$result['marca'];
							$modelo = isset($_POST["modelo"])?$_POST["modelo"]:$result['modelo'];
							$color = isset($_POST["color"])?$_POST["color"]:$result['color'];

							addslashes($marca);
							addslashes($modelo);
							addslashes($color);

							$result=$this -> model -> modificar($vin, $marca, $modelo, $color);
							if($result!==FALSE){
							    require_once("view/ModifyVehiculo.php");
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
							require_once("view/ShowVehiculo.php");
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
						require_once("view/ShowTodosVehiculos.php");
					}else{
						require_once("view/ErrorOperacion.php");
					}
				}
			break;
			case "eliminar":
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful())
							require_once("view/IngresaDatos.php");
					}else{
						$vin = isset($_POST["vin"])?$_POST["vin"]!==""?$_POST["vin"]:FALSE:FALSE;
						addslashes($vin);

						if ($vin!==FALSE) {
							$resultado = $this -> model -> eliminar($vin);
							if($resultado!==FALSE){
								require_once("view/VehiculoEliminado.php");
							}
							else{
								require_once("view/ErrorOperacion.php");
							}
						}else{
							require_once("view/ErrorOperacion.php");
						}//Fin de if ($vin!==FALSE)
					}//Fin del if(empty($_POST))
				break;
				default:
					require_once("view/Default.php");
			}//Fin de switch

		}//Fin de function execute

}//Fin de clase

?>