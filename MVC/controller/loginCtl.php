<?php

	Class LoginCtl{

		private $model;

		function execute(){
			require_once("model/LoginMdl.php");
			$this -> model = new LoginMdl();

			$vista="";

			if(!isset($_POST['usuario'])&&!isset($_POST['pass'])){
				echo $this->model->vista();
				exit();
			}


			$usuario= $_POST['usuario'];
			$clave= $_POST['pass'];
			
			$vista=$this->model->login($usuario, $clave);
			if($vista!==FALSE){
				echo $vista;
			}else{
				header("index.php");
				//cargar vista de usuario inexistenten y mostrarla con echo
				echo "El usuario no existe";
		}

		}


	}//fin de clase
?>