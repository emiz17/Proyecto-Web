<?php
Class EmpleadoCtl{
	private $model;

	public function execute(){
		require_once("model/EmpleadoMdl.php");
		$this -> model = new EmpleadoMdl();
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
					$res=TRUE;	

				    $nombre = isset($_POST["nombre"])?($_POST["nombre"]!=="")?$_POST["nombre"]:$res=FALSE:$res=FALSE;
				    $apPaterno = isset($_POST["apPaterno"])?($_POST["apPaterno"]!=="")?$_POST["apPaterno"]:$res=FALSE:$res=FALSE;
					$apMaterno= isset($_POST["apMaterno"])?($_POST["apMaterno"]!=="")?$_POST["apMaterno"]:$res=FALSE:$res=FALSE;
					$domicilio = isset($_POST["domicilio"])?($_POST["domicilio"]!=="")?$_POST["domicilio"]:$res=FALSE:$res=FALSE;
					$telefono = isset($_POST["telefono"])?($_POST["telefono"]!=="")?$_POST["telefono"]:$res=FALSE:$res=FALSE;
				    $correo = isset($_POST["correo"])?($_POST["correo"]!=="")?$_POST["correo"]:$res=FALSE:$res=FALSE;
					$idLogin = isset($_POST["idLogin "])?($_POST["idLogin "]!=="")?$_POST["idLogin "]:$res=FALSE:$res=FALSE;

					addslashes($nombre);
					addslashes($apPaterno);
					addslashes($apMaterno);
					addslashes($domicilio );
					addslashes($telefono);
					addslashes($correo);
					addslashes($idLogin);

					if ($res) {
						$resultado = $this -> model -> alta($nombre, $apPaterno, $apMaterno, $domicilio, $telefono, $correo, $idLogin);
						if($resultado!==FALSE){
						    require_once("view/AddEmpleado.php");
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
						if(!empty($_POST['$domicilio'])||!empty($_POST['telefono'])||!empty($_POST['correo'])||!empty($_POST['idLogin'])){
							//Se escribiran de nuevo los datos insertados
							$domicilio = isset($_POST["domicilio"])?$_POST["domicilio"]:$result['domicilio'];
							$telefono = isset($_POST["telefono"])?$_POST["telefono"]:$result['telefono'];
							$correo = isset($_POST["correo"])?$_POST["correo"]:$result['correo'];
							$idLogin = isset($_POST["idLogin"])?$_POST["idLogin"]:$result['idLogin'];

							addslashes($domicilio);
							addslashes($telefono);
							addslashes($correo);
							addslashes($idLogin);


							$result=$this -> model -> modificar($idEmpleado,$domicilio, $telefono, $correo, $idLogin);
							if($result!==FALSE){
							    require_once("view/ModifyEmpleado.php");
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
						require_once("view/InsertId.php");
				}//fin del if
				else{
					
					$idEmpleado = isset($_POST["idEmpleado"])?$_POST["idEmpleado"]!==""?$_POST["idEmpleado"]:FALSE:FALSE;
					addslashes($idCliente);
					if ($idCliente!==FALSE) {				
						$result=$this -> model -> mostrarDatos($idCliente);

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
			break;
			case "mostrarTodos":
				if($this->model->connection_successful()){
					$result= $this -> model -> mostrarTodos();
					if ($result!==FALSE) {			
						require_once("view/ShowTodosEmpleados.php");
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
				break;
				default:
					require_once("view/Default.php");
			}//Fin de switch

		}//Fin de function execute

}//Fin de clase

?>