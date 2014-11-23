<?php

	Class LoginMdl{
		private $driver;

		function __construct(){
				$host=$user=$pass=$db='';
				require_once("config.inc");
				/*var_dump($user);
				var_dump($host);
				var_dump($pass);
				var_dump($db);*/
				
				$this->driver=new mysqli($host, $user, $pass, $db);
				if($this->driver->connect_errno)
					require_once("view/ErrorOperacion.html");
		}


		function login($usuario, $pass){
			$view="";
			$result=$this->existeUsuario($usuario,$pass);
			if($result===true){
				$_SESSION['usuario'] = $usuario;
				$_SESSION['clave'] = $pass;
				$_SESSION['type'] =$this->obtenerTipo($usuario);
			}
			if($result===true){
				$view=$this->vista();
			}else{
				$view=FALSE;
			}

			return $view;

		}

		function vista(){
			$view="";
			if( isset($_SESSION['type']) && $_SESSION['type'] == 'admin' ){
				//header('Location: ../view/adminView.html');
				$view=file_get_contents("view/adminView.html");
			}else
				if( isset($_SESSION['type']) && $_SESSION['type'] == 'cliente' ){
					//header('Location: ../view/clienteView.html');
					$view=file_get_contents("view/clienteView.html");
				}else
					if( isset($_SESSION['type']) && $_SESSION['type'] == 'empleado' ){
						//header('Location: ../view/empleadoView.html');
						$view=file_get_contents("view/empleadoView.html");
					}else{
						header('Location: index.php');
					}
			return $view;
		}


			/************************************************
			*				VERIFICAR USUARIO				*
			*************************************************/
		function existeUsuario($usuario, $pass){
			$row=FALSE;

			$query="SELECT COUNT(*) AS cont FROM usuario WHERE usuario=\"$usuario\" AND clave=\"$pass\" ";

			$r=$this->driver->query($query);
			//var_dump($r);
			$row=$r->fetch_assoc();
			//var_dump($row); 
		//	echo "<br>cont:  " .$row['cont'];
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