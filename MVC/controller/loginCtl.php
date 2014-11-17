<?php
	$usuario= $_POST['usuario'];
	$pass= $_POST['pass'];

	echo "usuario $usuario  pass $pass  ";
	$login=new LoginCtl();
	$login->login($usuario, $pass);

	Class LoginCtl{
		private $driver;

		function __construct(){
				$host=$user=$pass=$db='';
				require_once("../config.inc");
				$this->driver=new mysqli($host, $user, $pass, $db);
				if($this->driver->connect_errno)
					require_once("view/ShowErrorConexion.php");
		}


		function login($usuario, $pass){
			//require_once("../model/UsuarioMdl.php");
			//$this->model = new UsuarioMdl();
			$result=$this->existeUsuario($usuario,$pass);
			if($result===true){
				session_start();
				$_SESSION['usuario'] = $usuario;
				$_SESSION['clave'] = $pass;
				$_SESSION['type'] =$this->obtenerTipo($usuario);

				echo '<a href="../index.php">Clic para regresar al index</a>';
			}
			else{
				echo "Usuario o Password incorrectos<br>";
				echo '<a href="../index.php">Clic para regresar al index</a>';
			}
			$this->vista();
			//$this->model->cerrarDB();
		}

		function vista(){
			if( isset($_SESSION['type']) && $_SESSION['type'] == 'admin' ){
				/*$content = file_get_contents('../view/BienvenidaInspeccion.html');
				echo $content;*/
				header('Location: ../view/BienvenidaInspeccion.html');
				}else
					if( isset($_SESSION['type']) && $_SESSION['type'] == 'cliente' ){
					/*$content = file_get_contents('../view/usuarioView.html');
					echo $content;*/
					header('Location: ../view/usuarioView.html');
					}else
					if( isset($_SESSION['type']) && $_SESSION['type'] == 'empleado' ){
						/*$content = file_get_contents('../view/usuarioMostrarView.html');
						echo $content;*/
						header('Location: ../view/usuarioMostrarView.html');
						}
					else{
					header('Location: ../index.html');
					}
		}


			/************************************************
			*				VERIFICAR USUARIO				*
			*************************************************/
		function existeUsuario($usuario, $pass){
			$row=FALSE;

			$query="SELECT COUNT(*) AS cont FROM usuario WHERE usuario=\"$usuario\" AND clave=\"$pass\" ";

			$r=$this->driver->query($query);
			//var_dump($r);
			echo "aa";
			$row=$r->fetch_assoc();
			//var_dump($row); 
			echo "<br>cont:  " .$row['cont'];
			if($row['cont']==0)
				$row=false;
			else 
				$row=true;
			return $row;

		/*function cerrarDB(){
			$this->driver->close();*/
		}


		/************************************************
		*					OBTENER TIPO				*
		*************************************************/
		function obtenerTipo($Usuario){
			$row=FALSE;

			$query="SELECT tipo_usuario FROM usuario WHERE usuario=\"$Usuario\" ";

			$r=$this->driver->query($query);

			
			$row=$r->fetch_assoc();
			//var_dump($row['tipo_usuario']);
			return $row['tipo_usuario'];
		}

	}
?>