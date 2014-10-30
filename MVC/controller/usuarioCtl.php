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

				    $nombreUsuario = isset($_POST["nombreUsuario"])?($_POST["nombreUsuario"]!=="")?$_POST["nombreUsuario"]:$res=FALSE:$res=FALSE;
				    $clave = isset($_POST["clave"])?($_POST["clave"]!=="")?$_POST["clave"]:$res=FALSE:$res=FALSE;
					$tipoUsuario= isset($_POST["tipoUsuario"])?($_POST["tipoUsuario"]!=="")?$_POST["tipoUsuario"]:$res=FALSE:$res=FALSE;
					$status = isset($_POST["status"])?($_POST["status"]!=="")?$_POST["status"]:$res=FALSE:$res=FALSE;
					$email = isset($_POST["email"])?($_POST["email"]!=="")?$_POST["email"]:$res=FALSE:$res=FALSE;

					addslashes($nombreUsuario);
					addslashes($clave);
					addslashes($tipoUsuario);
					addslashes($status);
					addslashes($email);

					if ($res) {
						$resultado = $this->model->alta($nombreUsuario, $clave, $tipoUsuario, $status, $email);

						if($resultado!==FALSE){
						    require_once("view/AddUsuario.php");
						    
						    //Preparamos datos para enviar el mail
						    $asunto="Bienvenido a WEB Solutions Team Vehiculo Project";
						    $mensaje="Gracias por elegirnos como su mejor opcion para guardar su coche.\n 
						    Disfrute su dia y nosotros nos encargamos de que su auto se encuentre seguro.";
						    $this->model->sendEmail($email, $nombreUsuario, $asunto, $mensaje);

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
					$idUsuario= $_POST["idUsuario"];
					addslashes($vin);
					
					//Se muestran los datos actuales
					$result=$this -> model -> mostrarDatos($idUsuario);

					if ($result!==FALSE) {
						require_once("view/ShowUsuario.php");
						echo "<br><br>Inserte el/los campos a modificar:<br>";
					}else{
						require_once("view/ErrorOperacion.php");
						echo "<br>";
						require_once("view/InsertId.php");
					}


					if ($result!==FALSE) {			
						if(!empty($_POST['nombreUsuario'])||!empty($_POST['clave'])||!empty($_POST['tipoUsuario'])||!empty($_POST['status'])||!empty($_POST['email'])){
							//Se escribiran de nuevo los datos insertados
							$nombreUsuario= isset($_POST["nombreUsuario"])?$_POST["nombreUsuario"]:$result['nombreUsuario'];
							$clave = isset($_POST["clave"])?$_POST["clave"]:$result['clave'];
							$tipoUsuario = isset($_POST["tipoUsuario"])?$_POST["tipoUsuario"]:$result['tipoUsuario'];
							$status  = isset($_POST["status "])?$_POST["status "]:$result['status '];
							$email = isset($_POST["email"])?($_POST["email"]!=="")?$_POST["email"]:$res=FALSE:$res=FALSE;

							addslashes($nombreUsuario);
							addslashes($clave);
							addslashes($tipoUsuario);
							addslashes($status);
							addslashes($email);


							$result=$this -> model -> modificar($usuario, $clave, $tipoUsuario, $status, $email);
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
					
					$idUsuario = isset($_POST["idUsuario"])?$_POST["idUsuario"]!==""?$_POST["idUsuario"]:FALSE:FALSE;
					addslashes($idUsuario);

					if ($idUsuario!==FALSE) {				
						$result=$this -> model -> mostrarDatos($idUsuario);

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
						$idUsuario = isset($_POST["idUsuario"])?$_POST["idUsuario"]!==""?$_POST["idUsuario"]:FALSE:FALSE;
						addslashes($idUsuario);

						if ($idUsuario!==FALSE) {
							$resultado = $this -> model -> eliminar($idUsuario);
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