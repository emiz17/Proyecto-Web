<?php
	Class UsuarioCtl{
		private $model;

		public function execute(){
			require_once("model/UsuarioMdl.php");
			$this -> model = new UsuarioMdl();
			require_once("controller/sesionesCtl.php");
			$comprueba= new SesionesCtl();

			$act=isset($_GET['act'])?$_GET['act']:"";
			if($comprueba->isLogged()){
				switch ($act){
					case "menu":
						$view=file_get_contents("view/usuarioMenuView.html");
						echo $view;
					break;
					case "alta":
						//Se carga la vista
					$view=file_get_contents("view/usuarioAltaView.html");
					if($comprueba->isAdmin()){
						if(empty($_POST)){
							if($this->model->connection_successful()){
								echo $view;
							}
						}//fin del if
						else{
						    //Obtener las variables para la alta
						    //y limpiarlas
							$res=TRUE;	

						    $usuario = isset($_POST["usuario"])?($_POST["usuario"]!=="")?$_POST["usuario"]:$res=FALSE:$res=FALSE;
						    $clave = isset($_POST["clave"])?($_POST["clave"]!=="")?$_POST["clave"]:$res=FALSE:$res=FALSE;
							$tipo_usuario= isset($_POST["tipo_usuario"])?($_POST["tipo_usuario"]!=="")?$_POST["tipo_usuario"]:$res=FALSE:$res=FALSE;
							$status = isset($_POST["status"])?($_POST["status"]!=="")?$_POST["status"]:$res=FALSE:$res=FALSE;
							$email = isset($_POST["email"])?($_POST["email"]!=="")?$_POST["email"]:$res=FALSE:$res=FALSE;

							addslashes($usuario);
							addslashes($clave);
							addslashes($tipo_usuario);
							addslashes($status);
							addslashes($email);

							if ($res) {
								$resultado = $this->model->alta($usuario, $clave, $tipo_usuario, $status, $email);

								if($resultado!==FALSE){
								    $codigoAgregado="<br /><h1>Vehiculo Agregado Exitosamente</h1><br /><br /><a href=\"index.php?ctl=vehiculo&act=alta\">Agregar Otro</a>";
									$view=$this->processView($result,"view/usuarioAltaView.html",$codigoAgregado);
									echo $view;
								    
								    //Preparamos datos para enviar el mail
								    $asunto="Bienvenido a WEB Solutions Team Vehiculo Project";
								    $mensaje="Gracias por elegirnos como su mejor opcion para guardar su coche.\n 
								    Disfrute su dia y nosotros nos encargamos de que su auto se encuentre seguro.";
								    $this->model->sendEmail($email, $usuario, $asunto, $mensaje);

								}else{
									require_once("view/ErrorOperacion.html");
								}//fin del if($resultado!==FALSE)
							}else{
								require_once("view/ErrorOperacion.html");
							}//fin del if ($res)
						}//fin del primer else
						}
						else
							echo "No tienes los permisos para realizar esta operacion";
					break;
					case "modificar":
					$view=file_get_contents("view/usuarioModificarView.html");
					if($comprueba->isAdmin() || $comprueba->isEmpleado()){
						if(empty($_POST)){
							//Cargo la vista de agrega datos
							if($this->model->connection_successful()){
								$view=$this->processView(FALSE,"view/usuarioModificarView.html",FALSE);
								echo $view;
							}
						}//fin del if
						else{
							//se buscara el usuario por ID
							$usuario= $_POST["usuario"];
							addslashes($usuario);
							
							//Se muestran los datos actuales
							$result=$this -> model -> mostrarDatos($usuario);

							if ($result!==FALSE&&(empty($_POST['usuario'])||empty($_POST['clave'])||empty($_POST['tipo_usuario'])||empty($_POST['status'])||empty($_POST['email']))) {
								$codigoAgregado="<h1>MODIFIQUE ALGUNO DE LOS SIGUIENTES CAMPOS</h1>	
									<form id=\"form_alta\" action=\"index.php?ctl=vehiculo&act=modificar\" method=\"POST\">
									<label for=\"usuario\">USUARIO*: {usuario}</label><input type=\"hidden\" id=\"usuario\" name=\"usuario\" size=\"25\" maxlength=\"25\" value=\"{usuario}\" />
									<br /><br />
									<label for=\"clave\">Password*:</label><input type=\"password\" id=\"clave\" name=\"clave\" size=\"22\" maxlength=\"45\" value=\"{clave}\" required autofocus />
									<br /><br />
									<label for=\"tipo_usuario\">Tipo de Usuario*:</label>
									<select name=\"tipo_usuario\" required>
										<option selected value=''>Elige una opcion</option>
										<option value=\"admin\">Administrador</option>
										<option value=\"cliente\">Cliente</option>
										<option value=\"empleado\">Empleado</option>
									</select>
									<br /><br />
									<fieldset>
										<legend>Status:</legend>
										<input type=\"radio\" name=\"status\" value=\"1\" checked>Activo
										<br />
										<input type=\"radio\" name=\"status\" value=\"0\">No Activo
									</fieldset>
									<br /><br />
									<label for=\"email\">Email*:</label><input type=\"email\" id=\"email\" name=\"email\" value=\"{email}\" required />
									<br /><br />
									<button type=\"submit\">Modificar</button>
									</form>";

								$view=$this->processView($result,"view/usuarioModificarView.html",$codigoAgregado);
								echo $view;

							}else{
								/*require_once("view/ErrorOperacion.php");
								echo "<br>";
								require_once("view/InsertId.php");*/
							}


							if ($result!==FALSE) {			
								if(!empty($_POST['usuario'])||!empty($_POST['clave'])||!empty($_POST['tipo_usuario'])||!empty($_POST['status'])||!empty($_POST['email'])){
									//Se escribiran de nuevo los datos insertados
									$usuario= isset($_POST["usuario"])?$_POST["usuario"]:$result["usuario"];
									$clave = isset($_POST["clave"])?$_POST["clave"]:$result['clave'];
									$tipo_usuario = isset($_POST["tipo_usuario"])?$_POST["tipo_usuario"]:$result['tipo_usuario'];
									$status  = isset($_POST["status"])?$_POST["status"]:$result["status"];
									$email = isset($_POST["email"])?$_POST["email"]:$result["email"];

									addslashes($usuario);
									addslashes($clave);
									addslashes($tipo_usuario);
									addslashes($status);
									addslashes($email);


									$result=$this -> model -> modificar($usuario, $clave, $tipo_usuario, $status, $email);
									if($result!==FALSE){
									    $codigoAgregado="<br /><h1>Modificacion Exitosa</h1><br /><br /><a href=\"index.php?ctl=usuario&act=modificar\">Modificar Otro</a>";
										$view=$this->processView($result,"view/usuarioModificarView.html",$codigoAgregado);
										echo $vehiculoView;
									}
									else{
										require_once("view/ErrorOperacion.html");
									}//fin del else del if($result!==FALSE)

								}//fin del if(!empty($_POST['marca'])||...

							}//fin del if ($result!==NULL)
							
						}//fin del else del if(empty($_POST))
							}
						else
							echo "No tienes los permisos para realizar esta operacion";
					break;	
					case "mostrar":
					$view=file_get_contents("view/usuarioMostrarView.html");
					if($comprueba->isAdmin()|| $comprueba->isEmpleado() || $comprueba->isCliente()){
						if(empty($_POST)){
							//Cargo la vista de agrega datos
							if($this->model->connection_successful()){
								$view=$this->processView(FALSE,"view/usuarioMostrarView.html",FALSE);
								echo $view;
								}
						}//fin del if
						else{
							
							$usuario = isset($_POST["usuario"])?$_POST["usuario"]!==""?$_POST["usuario"]:FALSE:FALSE;
							addslashes($usuario);

							if ($usuario!==FALSE) {				
								$result=$this -> model -> mostrarDatos($usuario);

								//Si existe el VIN, muestralo, si no, manda error
								if($result!==FALSE){
									$codigoAgregado="<table id=\"table\"><thead><tr><th>USUARIO</th><th>TIPO DE USUARIO</th><th>STATUS</th><th>EMAIL</th></tr></thead>
									{Inicio_tabla}<tbody><tr><td>{usuario}</td><td>{tipo_usuario}</td><td>{status}</td><td>{email}</td></tr>
										</tbody>{Fin_tabla}</table>";

									$view=$this->processView($result,"view/usuarioMostrarView.html",$codigoAgregado);
									echo $view;
								}else{
									require_once("view/ErrorOperacion.html");
									echo "<br>";
									echo $view;
								}

							}else{
								require_once("view/ErrorOperacion.html");
								echo "<br>";
								echo $view;
							}

						}//fin de else
						}
					else 
						echo "No tienes los permisos para realizar esta operacion";
					break;
					case "mostrarTodos":
					$view=file_get_contents("view/usuarioMostrarTodosView.html");
					if($comprueba->isAdmin() || $comprueba->isEmpleado()){
						if($this->model->connection_successful()){
							$result= $this -> model -> mostrarTodos();
							if ($result!==FALSE) {			
								$view=$this->processView($result,"view/usuarioMostrarTodosView.html",FALSE);
								echo $view;
							}else{
								require_once("view/ErrorOperacion.html");
							}
						}
						}
					else 
						echo "No tienes los permisos para realizar esta operacion";
					break;
					case "eliminar":
						if($comprueba->isAdmin()){
							if(empty($_POST)){
								//Cargo la vista de agrega datos
								if($this->model->connection_successful())
									require_once("view/IngresaDatos.html");
							}else{
								$usuario = isset($_POST["usuario"])?$_POST["usuario"]!==""?$_POST["usuario"]:FALSE:FALSE;
								addslashes($usuario);

								if ($usuario!==FALSE) {
									$resultado = $this -> model -> eliminar($usuario);
									if($resultado!==FALSE){
										require_once("view/UsuarioEliminado.html");
									}
									else{
										require_once("view/ErrorOperacion.html");
									}
								}else{
									require_once("view/ErrorOperacion.html");
								}
							}//Fin del if(empty($_POST))
						}
						else
							echo "No tienes los permisos para realizar esta operacion";
					break;
					case "menu":
					$view=file_get_contents("view/usuarioMenuView.html");
					echo $view;
					break;
					default:
						$view=file_get_contents("view/Default.html");
						echo $view;
				}//Fin de switch
			}//fin de if logged
			else{
				echo 'Necesitas ingresar al sistema <br>';
				echo '<a href="controller/loginCtl.php?usuario=pedro&pass=ge">Clic para hacer login</a>';
			}

		}//Fin de function execute


		public function processView($array, $vistaPath, $codigoAgregado){

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
						"{usuario}" => $row["usuario"],
						'{tipo_usuario}' => $row["tipo_usuario"],
						'{status}' => $row["status"],
						'{email}' => $row["email"]);
						$new_fila = strtr($new_fila,$diccionario);
						$filas .= $new_fila;
					}
				}else{
					$diccionario = array(
						"{usuario}" => $row["usuario"],
						'{tipo_usuario}' => $row["tipo_usuario"],
						'{status}' => $row["status"],
						'{email}' => $row["email"]);
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