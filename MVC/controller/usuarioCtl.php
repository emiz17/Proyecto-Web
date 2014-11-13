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
					case "alta":
					if($comprueba->isAdmin()){
						if(empty($_POST)){
							if($this->model->connection_successful())
								require_once("view/IngresaDatos.php");
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
								    require_once("view/AddUsuario.php");
								    
								    //Preparamos datos para enviar el mail
								    $asunto="Bienvenido a WEB Solutions Team Vehiculo Project";
								    $mensaje="Gracias por elegirnos como su mejor opcion para guardar su coche.\n 
								    Disfrute su dia y nosotros nos encargamos de que su auto se encuentre seguro.";
								    $this->model->sendEmail($email, $usuario, $asunto, $mensaje);

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
					if($comprueba->isAdmin() || $comprueba->isEmpleado()){
						if(empty($_POST)){
							//Cargo la vista de agrega datos
							if($this->model->connection_successful())
								require_once("view/InsertId.php");
						}//fin del if
						else{
							//se buscara el usuario por ID
							$usuario= $_POST["usuario"];
							addslashes($usuario);
							
							//Se muestran los datos actuales
							$result=$this -> model -> mostrarDatos($usuario);

							if ($result!==FALSE) {
								require_once("view/ShowUsuario.php");
								echo "<br><br>Inserte el/los campos a modificar:<br>";
							}else{
								require_once("view/ErrorOperacion.php");
								echo "<br>";
								require_once("view/InsertId.php");
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
									    require_once("view/ModifyUsuario.php");
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
								require_once("view/InsertId.php");
						}//fin del if
						else{
							
							$usuario = isset($_POST["usuario"])?$_POST["usuario"]!==""?$_POST["usuario"]:FALSE:FALSE;
							addslashes($usuario);

							if ($usuario!==FALSE) {				
								$result=$this -> model -> mostrarDatos($usuario);

								//Si existe el VIN, muestralo, si no, manda error
								if($result!==FALSE){
									require_once("view/ShowUsuario.php");
								}else{
									require_once("view/ErrorOperacion.php");
									echo "<br>";
									require_once("view/InsertId.php");
								}

							}else{
								require_once("view/ErrorOperacion.php");
								echo "<br>";
								require_once("view/InsertId.php");
							}

						}//fin de else
						}
					else 
						echo "No tienes los permisos para realizar esta operacion";
					break;
					case "mostrarTodos":
					if($comprueba->isAdmin() || $comprueba->isEmpleado()){
						if($this->model->connection_successful()){
							$result= $this -> model -> mostrarTodos();
							if ($result!==FALSE) {			
								require_once("view/ShowTodosUsuarios.php");
							}else{
								require_once("view/ErrorOperacion.php");
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
									require_once("view/IngresaDatos.php");
							}else{
								$usuario = isset($_POST["usuario"])?$_POST["usuario"]!==""?$_POST["usuario"]:FALSE:FALSE;
								addslashes($usuario);

								if ($usuario!==FALSE) {
									$resultado = $this -> model -> eliminar($usuario);
									if($resultado!==FALSE){
										require_once("view/UsuarioEliminado.php");
									}
									else{
										require_once("view/ErrorOperacion.php");
									}
								}else{
									require_once("view/ErrorOperacion.php");
								}
							}//Fin del if(empty($_POST))
						}
						else
							echo "No tienes los permisos para realizar esta operacion";
					break;
					default:
						require_once("view/Default.php");
				}//Fin de switch
			}//fin de if logged
			else{
				echo 'Necesitas ingresar al sistema <br>';
				echo '<a href="controller/loginCtl.php?usuario=pedro&pass=ge">Clic para hacer login</a>';
			}

		}//Fin de function execute

	}//Fin de clase

?>