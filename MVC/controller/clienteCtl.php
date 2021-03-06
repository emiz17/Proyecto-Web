<?php
Class ClienteCtl{
	private $model;

	public function execute(){
		require_once("model/ClienteMdl.php");
		$this -> model = new ClienteMdl();
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

				    $nombre = isset($_POST["nombre"])?($_POST["nombre"]!=="")?$_POST["nombre"]:$res=FALSE:$res=FALSE;
				    $apellidos = isset($_POST["apellidos"])?($_POST["apellidos"]!=="")?$_POST["apellidos"]:$res=FALSE:$res=FALSE;
					$domicilio = isset($_POST["domicilio"])?($_POST["domicilio"]!=="")?$_POST["domicilio"]:$res=FALSE:$res=FALSE;
					$telefono = isset($_POST["telefono"])?($_POST["telefono"]!=="")?$_POST["telefono"]:$res=FALSE:$res=FALSE;
					$usuario = isset($_POST["usuario"])?($_POST["usuario"]!=="")?$_POST["usuario"]:$res=FALSE:$res=FALSE;

					addslashes($nombre);
					addslashes($apellidos);
					addslashes($domicilio);
					addslashes($telefono);
					addslashes($usuario);


					if ($res) {
						$resultado = $this -> model -> alta($nombre, $apellidos, $domicilio, $telefono, $usuario);
						if($resultado!==FALSE){
						    require_once("view/AddCliente.php");
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
			if($comprueba->isAdmin()|| $comprueba->isEmpleado()){
				if(empty($_POST)){
					//Cargo la vista de agrega datos
					if($this->model->connection_successful())
						require_once("view/InsertId.php");
				}//fin del if
				else{
					$idCliente = $_POST["idCliente"];
					addslashes($idCliente);
					
					//Se muestran los datos actuales
					$result=$this -> model -> mostrarDatos($idCliente);

					if ($result!==FALSE) {
						require_once("view/ShowCliente.php");
						echo "<br><br>Inserte el/los campos a modificar:<br>";
					}else{
						require_once("view/ErrorOperacion.php");
						echo "<br>";
						require_once("view/InsertId.php");
					}


					if ($result!==FALSE) {		
						if(!empty($_POST['nombre'])||!empty($_POST['apellidos'])||!empty($_POST['domicilio'])||!empty($_POST['telefono'])){
							//Se escribiran de nuevo los datos insertados
							$nombre = isset($_POST["nombre"])?$_POST["nombre"]:$result["nombre"];
							$apellidos = isset($_POST["apellidos"])?$_POST["apellidos"]:$result["apellidos"];
							$domicilio = isset($_POST["domicilio"])?$_POST["domicilio"]:$result["domicilio"];
							$telefono = isset($_POST["telefono"])?$_POST["telefono"]:$result["telefono"];
							
							addslashes($nombre);
							addslashes($apellidos);
							addslashes($domicilio);
							addslashes($telefono);


							$result=$this -> model -> modificar($idCliente, $nombre, $apellidos, $domicilio, $telefono);
							if($result!==FALSE){
							    require_once("view/ModifyCliente.php");
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
					
					$idCliente = isset($_POST["idCliente"])?$_POST["idCliente"]!==""?$_POST["idCliente"]:FALSE:FALSE;
					addslashes($idCliente);
					if ($idCliente!==FALSE) {				
						$result=$this -> model -> mostrarDatos($idCliente);

						//Si existe el idCliente muestralo, si no, manda error
						if($result!==FALSE){
							require_once("view/ShowCliente.php");
						}else{
							require_once("view/ErrorOperacion.php");
							echo "<br>";
							require_once("view/InsertId.php");
						}

					}else{//Si no esta seteado el idCliente
						require_once("view/ErrorOperacion.php");
						echo "<br>";
						require_once("view/InsertId.php");
					}//fin del if ($idcliente!==FALSE)

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
						require_once("view/ShowTodosClientes.php");
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
						$idCliente = isset($_POST["idCliente"])?$_POST["idCliente"]!==""?$_POST["idCliente"]:FALSE:FALSE;
						addslashes($idCliente);

						if ($idCliente!==FALSE) {
							$resultado = $this -> model -> eliminar($idCliente);
							if($resultado!==FALSE){
								require_once("view/ClienteEliminado.php");
							}
							else{
								require_once("view/ErrorOperacion.php");
							}
						}else{
							require_once("view/ErrorOperacion.php");
						}//Fin de if ($idCliente!==FALSE)
					}//Fin del if(empty($_POST))
				}else
					echo "No tienes los permisos para realizar esta operacion";
				break;
				case "menu":
					$view=file_get_contents("view/clienteMenuView.html");
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

}//Fin de clase

?>