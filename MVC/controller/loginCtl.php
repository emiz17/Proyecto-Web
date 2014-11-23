<?php

	Class LoginCtl{

		private $model;

		function execute(){
			require_once("model/LoginMdl.php");
			$this -> model = new LoginMdl();

			$vista="";
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