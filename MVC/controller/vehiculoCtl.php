<?php
	Class VehiculoCtl{
		private $model;

		public function execute(){
			require_once("model/VehiculoMdl.php");
			$this -> model = new VehiculoMdl();
			require_once("controller/sesionesCtl.php");
			$comprueba= new SesionesCtl();
			$act=isset($_GET['act'])?$_GET['act']:"";
			if($comprueba->isLogged()){
			switch ($act){
				case "menu":
					$vehiculoView=file_get_contents("view/vehiculoView.html");
					echo $vehiculoView;
				break;
				case "alta":
				if($comprueba->isAdmin()){
					if(empty($_POST)){
						if($this->model->connection_successful()){
							$vehiculoView=file_get_contents("view/vehiculoAltaView.html");
							echo $vehiculoView;
						}
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
						$idCliente = isset($_POST["idCliente"])?($_POST["idCliente"]!=="")?$_POST["idCliente"]:$res=FALSE:$res=FALSE;

						addslashes($vin);
						addslashes($marca);
						addslashes($modelo);
						addslashes($color);
						addslashes($idCliente);

						//el vin se puede validar pero aun no se encuentra un estandar
	  					//que usar-> 17 caracteres , cualquiera menos I,O,Q y Ñ
	  					// primerods 3 son WMI
	  					//sig 6 son VDS
	  					//ultimos VIS
	  					//basado en http://www.guiaautomotrizcr.com/Articulos/numero_VIN.php

						if ($res) {
							$resultado = $this -> model -> alta($vin,$marca,$modelo,$color, $idCliente);
							if($resultado!==FALSE){
							    $codigoAgregado="<br /><h1>Vehiculo Agregado Exitosamente</h1><br /><br /><a href=\"index.php?ctl=vehiculo&act=alta\">Agregar Otro</a>";
								    $vehiculoView=file_get_contents("view/vehiculoAltaView.html");
									$vehiculoView=$this->processView($result,"view/vehiculoAltaView.html",$codigoAgregado);
									echo $vehiculoView;
							}else{
								require_once("view/ErrorOperacion.php");
							}//fin del if($resultado!==FALSE)
						}else{
							require_once("view/ErrorOperacion.php");
						}//fin del if ($res)
					}//fin del primer else
				}
				else
					echo "<br>No tienes los permisos para realizar esta operacion";
				break;
				case "modificar":
				if($comprueba->isAdmin() || $comprueba->isEmpleado()){
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful()){
							$vehiculoView=file_get_contents("view/vehiculoModificarView.html");
							$vehiculoView=$this->processView(FALSE,"view/vehiculoModificarView.html",FALSE);
							echo $vehiculoView;
						}
					}//fin del if
					else{
						//se buscara el vehiculo por VIN

						$vin = $_POST["vin"];
						addslashes($vin);
						
						//Se muestran los datos actuales
						$result=$this -> model -> mostrarDatos($vin);

						if ($result!==FALSE&&(empty($_POST['marca'])||empty($_POST['modelo'])||empty($_POST['color']))) {
							$codigoAgregado="<h1>MODIFIQUE ALGUNO DE LOS SIGUIENTES CAMPOS</h1>	
								<form id=\"form_alta\" action=\"index.php?ctl=vehiculo&act=modificar\" method=\"POST\">
								<label for=\"vin\">VIN*: {VIN}</label><input type=\"hidden\" id=\"vin\" name=\"vin\" size=\"22\" maxlength=\"17\" value=\"{VIN}\" />
								<br /><br />
								<label for=\"marca\">Marca*:</label><input type=\"text\" id=\"marca\" name=\"marca\" size=\"22\" maxlength=\"25\" value=\"{marca}\" required autofocus />
								<br /><br />
								<label for=\"modelo\">Modelo*:</label><input type=\"text\" id=\"modelo\" name=\"modelo\" size=\"22\" maxlength=\"4\" value=\"{modelo}\" required />
								<br /><br />
								<label for=\"color\">Color*:</label><input type=\"color\" id=\"color\" name=\"color\" value=\"{color}\" required />
								<br /><br />
								<button type=\"submit\">Modificar</button>
								</form>";

							$vehiculoView=file_get_contents("view/vehiculoModificarView.html");
							$vehiculoView=$this->processView($result,"view/vehiculoModificarView.html",$codigoAgregado);
							echo $vehiculoView;

						}else{
							/*require_once("view/ErrorOperacion.php");
							echo "<br>";
							require_once("view/InsertVIN.php");*/
							
						}
						

						if ($result!==FALSE) {			
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
									$codigoAgregado="<br /><h1>Modificacion Exitosa</h1><br /><br /><a href=\"index.php?ctl=vehiculo&act=modificar\">Modificar Otro</a>";
								    $vehiculoView=file_get_contents("view/vehiculoModificarView.html");
									$vehiculoView=$this->processView($result,"view/vehiculoModificarView.html",$codigoAgregado);
									echo $vehiculoView;
								}
								else{
									require_once("view/ErrorOperacion.php");
								}//fin del else del if($result!==FALSE)

							}//fin del if(!empty($_POST['marca'])||...

						}//fin del if ($result!==NULL)
						
					}//fin del else del if(empty($_POST))
				}
				else
					echo "<br>No tienes los permisos para realizar esta operacion";
				break;	
				case "mostrar":
				if($comprueba->isAdmin()|| $comprueba->isEmpleado() || $comprueba->isCliente()){
					if(empty($_POST)){
						//Cargo la vista de agrega datos
						if($this->model->connection_successful()){
							$vehiculoView=file_get_contents("view/vehiculoMostrarView.html");
							$vehiculoView=$this->processView(FALSE,"view/vehiculoMostrarView.html",FALSE);
							echo $vehiculoView;
						}
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

								$codigoAgregado="<table id=\"table\"><thead><tr><th>VIN</th><th>Marca</th><th>Modelo</th><th>Color</th></tr></thead>
									{Inicio_tabla}<tbody><tr><td>{VIN}</td><td>{marca}</td><td>{modelo}</td><td>{color}</td></tr>
										</tbody>{Fin_tabla}</table>";

								$vehiculoView=file_get_contents("view/vehiculoMostrarView.html");
								$vehiculoView=$this->processView($result,"view/vehiculoMostrarView.html",$codigoAgregado);
								echo $vehiculoView;
							}else{
								require_once("view/ErrorOperacion.php");
								echo "<br>";
								$vehiculoView=file_get_contents("view/vehiculoMostrarView.html");
								echo $vehiculoView;
							}

						}else{//Si no esta seteado el VIN
							$vehiculoView=file_get_contents("view/vehiculoMostrarView.html");
								echo $vehiculoView;
						}//fin del if ($vin!==FALSE)

					}//fin de else
				}
				else 
					echo "<br>No tienes los permisos para realizar esta operacion";
				break;
				case "mostrarTodos":
						//despues se contara con un diccionario 
						//para saber que dato nos proporciona el vin y mostrarlos
				if($comprueba->isAdmin() || $comprueba->isEmpleado()){
					if($this->model->connection_successful()){
						$result= $this -> model -> mostrarTodos();
						if ($result!==FALSE) {			
							$vehiculoView=file_get_contents("view/vehiculoMostrarTodosView.html");
							$vehiculoView=$this->processView($result,"view/vehiculoMostrarTodosView.html",FALSE);
							echo $vehiculoView;
						}else{
							require_once("view/ErrorOperacion.php");
						}
					}
				}
				else 
					echo "<br>No tienes los permisos para realizar esta operacion";
				break;

				/*case "eliminar":
				if($comprueba->isAdmin()){
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
					}
					else
						echo "<br>No tienes los permisos para realizar esta operacion";
					break;*/
					default:
						require_once("view/Default.php");
				}//Fin de switch
			}//fin de if logged
			else{
				echo "<br>Aun no has ingresado al sistema <br>";
				echo '<a href="controller/loginCtl.php?usuario=pedro&pass=ge">Clic para hacer login</a>';
			}

		}//Fin de function execute


		public function processView($array,$vistaPath, $codigoAgregado){

			//Procesar la vista
			//Obtener la vista
			$vista = file_get_contents($vistaPath);
			//$header = file_get_contents("view/header.html");
			//$footer = file_get_contents("view/footer.html");

			//echo "<br>debug: Va a cargar la vista en base a lo devuelto por el modelo";
			if($array!==FALSE){
				
				if($codigoAgregado!==FALSE){

					$inicio_fila = strrpos($vista,'{Inicio_tabla}');
					$final_fila = strrpos($vista,'{Fin_tabla}');
					$fila = substr($vista,$inicio_fila,$final_fila-$inicio_fila);

					$vista = str_replace($fila, $codigoAgregado, $vista);
				}	

				//Obtengo la fila de la tabla
				$inicio_fila = strrpos($vista,'{Inicio_tabla}');
				$final_fila = strrpos($vista,'{Fin_tabla}');
				$fila = substr($vista,$inicio_fila,$final_fila-$inicio_fila);


				if($codigoAgregado===FALSE){
					//Genero las filas
					$filas="";
					foreach ($array as $row) {
						$new_fila = $fila;

						//$new_fila = str_replace('{codigo}', $row['id'], $new_fila);
						//$new_fila = str_replace('{nombre}', $row['nombre'], $new_fila);
						//Reemplazo con un diccionario
						$diccionario = array(
						"{VIN}" => $row["VIN"],
						'{marca}' => $row["marca"],
						'{modelo}' => $row["modelo"],
						'{color}' => $row["color"]);
						$new_fila = strtr($new_fila,$diccionario);
						$filas .= $new_fila;
					}
				}else{
					$diccionario = array(
						"{VIN}" => $array["VIN"],
						'{marca}' => $array["marca"],
						'{modelo}' => $array["modelo"],
						'{color}' => $array["color"]);
						$filas = strtr($fila,$diccionario);
				}

				//Reemplazo en mi vista una fila por todas las filas
				$vista = str_replace($fila, $filas, $vista);
				
				
				//Reemplazo con un diccionario
				/*$diccionario = array(
				'{pagina}' => 'Vehiculo',
				'{extras}' => '',
				'{usuario}' => 'pedro');
				$vista = strtr($vista,$diccionario);
				//$header = strtr($header,$diccionario);
				//$vista = $header . $vista . $footer;*/
				
				//Mostrar la vista
				
			}

			$tabla=array(
					'{Inicio_tabla}'=>"",
					'{Fin_tabla}'=>""
					);
			$vista=strtr($vista, $tabla);

			echo $vista;
			
		}//fin de la funcion procesarVista

	}//Fin de clase

?>