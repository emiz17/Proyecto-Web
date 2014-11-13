<?php
Class EmpleadoCtl{
	private $model;

	public function execute(){
		require_once("model/EmpleadoMdl.php");
		$this -> model = new EmpleadoMdl();
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
						    require_once("view/AddEmpleado.php");
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
					$idEmpleado = $_POST["idEmpleado"];
					addslashes($idEmpleado);
					
					//Se muestran los datos actuales
					$result=$this -> model -> mostrarDatos($idEmpleado);

					if ($result!==FALSE) {
						require_once("view/ShowEmpleado.php");
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

							$result=$this -> model -> modificar($idEmpleado, $nombre, $apellidos, $domicilio, $telefono);
							if($result!==FALSE){
							    require_once("view/ModifyEmpleado.php");
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
					
					$idEmpleado = isset($_POST["idEmpleado"])?$_POST["idEmpleado"]!==""?$_POST["idEmpleado"]:FALSE:FALSE;
					addslashes($idEmpleado);
					if ($idEmpleado!==FALSE) {				
						$result=$this -> model -> mostrarDatos($idEmpleado);

						//Si existe el idCliente muestralo, si no, manda error
						if($result!==FALSE){
							require_once("view/ShowEmpleado.php");
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
						require_once("view/ShowTodosEmpleados.php");
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
						$idEmpleado = isset($_POST["idEmpleado"])?$_POST["idEmpleado"]!==""?$_POST["idEmpleado"]:FALSE:FALSE;
						addslashes($idEmpleado);

						if ($idEmpleado!==FALSE) {
							$resultado = $this -> model -> eliminar($idEmpleado);
							if($resultado!==FALSE){
								require_once("view/EmpleadoEliminado.php");
							}
							else{
								require_once("view/ErrorOperacion.php");
							}
						}else{
							require_once("view/ErrorOperacion.php");
						}//Fin de if ($idEmpleado!==FALSE)
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