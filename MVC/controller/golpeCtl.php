<?php
	class GolpeCtl {
		private $model;
		
		public function execute(){
			require_once("model/GolpeMdl.php");
			$this->model=new GolpeMdl();
			require_once("controller/sesionesCtl.php");
			$comprueba= new SesionesCtl();

			$act=isset($_GET['act'])?$_GET['act']:"";
			if($comprueba->isLogged()){
			switch($act){
				case "alta":
				if($comprueba->isAdmin()){
					if(empty($_POST)){
						//carga la vista alumno sin post
						if($this->model->connection_successful())
							require_once("view/IngresaDatos.php");
					}else{
						//Obtener las variables para la alta
					    //y limpiarlas
					    //en lo que se obtiene exactamente lo que significa el contenido del vin
					    //de las siguientes se borraran la de marca y modelo menos la del color
						$res=TRUE;	

					    $vin = isset($_POST["vin"])?($_POST["vin"]!=="")?$_POST["vin"]:$res=FALSE:$res=FALSE;
					    $pieza = isset($_POST["pieza"])?($_POST["pieza"]!=="")?$_POST["pieza"]:$res=FALSE:$res=FALSE;
						$severidad = isset($_POST["severidad"])?($_POST["severidad"]!=="")?$_POST["severidad"]:$res=FALSE:$res=FALSE;

						addslashes($vin);
						addslashes($pieza);
						addslashes($severidad);

						//el vin se puede validar pero aun no se encuentra un estandar
	  					//que usar-> 17 caracteres , cualquiera menos I,O,Q y Ñ
	  					// primerods 3 son WMI
	  					//sig 6 son VDS
	  					//ultimos VIS
	  					//basado en http://www.guiaautomotrizcr.com/Articulos/numero_VIN.php

						if ($res) {
							$result=$this->model->alta($vin, $pieza, $severidad);
							if($result!==FALSE){
							    require_once("view/AddGolpe.php");
							}else{
								require_once("view/ErrorOperacion.php");
							}//fin del if($resultado!==FALSE)
						}else{
							require_once("view/ErrorOperacion.php");
						}//fin del if ($res)
					}//fin del primer else
					}
				else
					echo "No tienes los permisos para realizar esta operacion";
				break;
				case "modificar":
				if($comprueba->isAdmin())|| $comprueba->isEmpleado(){
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
							require_once("view/ShowGolpe.php");
							echo "<br><br>Inserte el/los campos a modificar:<br>";
						}else{
							require_once("view/ErrorOperacion.php");
							echo "<br>";
							require_once("view/InsertVIN.php");
						}


						if ($result!==FALSE) {			
							if(!empty($_POST['pieza'])||!empty($_POST['severidad'])){
								//Se escribiran de nuevo los datos insertados
								$pieza = isset($_POST["pieza"])?$_POST["pieza"]:$result['pieza'];
								$severidad = isset($_POST["severidad"])?$_POST["severidad"]:$result['severidad'];

								addslashes($pieza);
								addslashes($severidad);

								$result=$this -> model -> modificar($vin, $pieza, $severidad);
								if($result!==FALSE){
								    require_once("view/ModifyGolpe.php");
								}
								else{
									require_once("view/ErrorOperacion.php");
								}//fin del else del if($result!==FALSE)

							}//fin del if(!empty($_POST['marca'])||...

						}//fin del if ($result!==NULL)
						
					}//fin del else del if(empty($_POST))
					}
				else
					echo "No tienes los permisos para realizar esta operacion";
				break;
				case "mostrar":
				if($comprueba->isAdmin()|| $comprueba->isEmpleado() || $comprueba->isCliente()){
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
								require_once("view/ShowGolpe.php");
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
					}
			else 
				echo "No tienes los permisos para realizar esta operacion";
				break;
				case "mostrarTodos":
				if($comprueba->isAdmin() || $comprueba->isEmpleado()){
					//despues se contara con un diccionario 
					//para saber que dato nos proporciona el vin y mostrarlos
					if($this->model->connection_successful()){
						$result= $this -> model -> mostrarTodos();
						if ($result!==FALSE) {			
							require_once("view/ShowTodosGolpe.php");
						}else{
							require_once("view/ErrorOperacion.php");
						}
					}
					}
			else 
				echo "No tienes los permisos para realizar esta operacion";
				break;
				default:
					require_once("view/Default.php");
			}
					}//fin de if logged
		else{
			echo 'Necesitas ingresar al sistema <br>';
			echo '<a href="controller/loginCtl.php?usuario=pedro&pass=ge">Clic para hacer login</a>';
		}
		}
	
	}

?>