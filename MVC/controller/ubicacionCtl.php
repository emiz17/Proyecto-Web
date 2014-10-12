<?php
	Class UbicacionCtl{
		private $model;


		


		//y realizar la validacion de las palabras
		//prueba.....
		public function execute(){
		    require_once("model/UbicacionMdl.php");
		    $this -> model = new UbicacionMdl();
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
					    $ubicacion = isset($_POST["ubicacion"])?($_POST["ubicacion"]!=="")?$_POST["ubicacion"]:$res=FALSE:$res=FALSE;
						$movidoPor = isset($_POST["movidoPor"])?($_POST["movidoPor"]!=="")?$_POST["movidoPor"]:$res=FALSE:$res=FALSE;
						$motivo = isset($_POST["motivo"])?($_POST["motivo"]!=="")?$_POST["motivo"]:$res=FALSE:$res=FALSE;
						$fecha = isset($_POST["fecha"])?($_POST["fecha"]!=="")?$_POST["fecha"]:$res=FALSE:$res=FALSE;
						$hora = isset($_POST["hora"])?($_POST["hora"]!=="")?$_POST["hora"]:$res=FALSE:$res=FALSE;

						if($this->validar_fecha($fecha) && $this->validar_hora($hora)){

							addslashes($vin);
		  					addslashes($ubicacion);
		  					addslashes($movidoPor);
		  					addslashes($motivo);
		  					//addslashes($fecha);
		  					//addslashes($hora);

							if ($res) {
								$resultado = $this -> model -> alta($vin, $ubicacion, $movidoPor, $motivo, $fecha, $hora);
								if($resultado!==FALSE){
								    require_once("view/AddUbicacion.php");
								}else{
									require_once("view/ErrorOperacion.php");
								}//fin del if($resultado!==FALSE)
							}else{
								require_once("view/ErrorOperacion.php");
							}//fin del if ($res)
						}//fin del if de validacion fecha y hora
						else{
							require_once("view/ErrorOperacion.php");
						}//fin else validacion fecha hora
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
							require_once("view/ShowUbicacion.php");
							echo "<br><br>Inserte el/los campos a modificar:<br>";
						}else{
							require_once("view/ErrorOperacion.php");
							echo "<br>";
							require_once("view/InsertVIN.php");
						}


						if ($result!==FALSE) {			
							if(!empty($_POST['ubicacion'])||!empty($_POST['movidoPor'])||!empty($_POST['motivo'])||!empty($_POST['fecha'])||!empty($_POST['hora'])){

								//Se escribiran de nuevo los datos insertados
								$ubicacion = isset($_POST["ubicacion"])?$_POST["ubicacion"]:$result["ubicacion"];
								$movidoPor = isset($_POST["movidoPor"])?$_POST["movidoPor"]:$result["nombre_chofer"];
								$motivo = isset($_POST["motivo"])?$_POST["motivo"]:$result["motivo"];
								$fecha = isset($_POST["fecha"])?$_POST["fecha"]:$result["fecha"];
								$hora = isset($_POST["hora"])?$_POST["hora"]:$result["hora"];

								if($this->validar_fecha($fecha) && $this->validar_hora($hora)){

				  					addslashes($ubicacion);
				  					addslashes($movidoPor);
				  					addslashes($motivo);
				  					//addslashes($fecha);
				  					//addslashes($hora);

									$result=$this -> model -> modificar($vin, $ubicacion, $movidoPor, $motivo, $fecha, $hora);
									if($result!==FALSE){
									    require_once("view/ModifyUbicacion.php");
									}
									else{
										require_once("view/ErrorOperacion.php");
									}//fin del else del if($result!==FALSE)

								}//fin if validacion fecha hora
								else{
									require_once("view/ErrorOperacion.php");
								}//fin else validacion fecha hora

							}//fin del if(!empty($_POST['marca'])||...

						}//fin del if ($result!==FALSE)
						
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
								require_once("view/ShowUbicacion.php");
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
							require_once("view/ShowTodosUbicacion.php");
						}else{
							require_once("view/ErrorOperacion.php");
						}
					}
				break;
				default:
					 require_once("view/Default.php");
			}//Fin de switch
		}//fin de function execute

		//formato MM/DD/YYYY 
		private function validar_fecha($fecha){
			$pattern="/^\d{4}(\/|-)\d{1,2}(\/|-)\d{1,2}$/";
			if (preg_match($pattern,$fecha))
				return true;
			return false;
		}//fin de function validar_fecha


		private function validar_hora($hora) {
			$pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/";
			if(preg_match($pattern,$hora)) 
				return true; 
			return false; 
		}//fin de function validar_hora

	}//Fin de clase

?>
