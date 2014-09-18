<?php
	//require_once('model/cursos.php');
	//require_once('model/ciclos.php');
	//require_once('model/evaluacion.php');
	//require_once('model/altas.php');
	//require_once('model/calificaciones.php');
	

	function handler() {
		if(isset($_GET['seccion']))
			$section=$_GET['seccion'];
		else
			$seccion="";
		
		
		switch ($section) {
			case 'ciclos':
				$ciclo=new Ciclo();
				require_once("views/capturar_ciclo.php");
			break;
			case 'cursos':
				$curso=new Curso();
				require_once("views/capturar_curso.php");
			break;
			case 'evaluacion':
				$regla_Eval=new ReglaEval();
				require_once("views/capturar_reglas_eval.php");
			break;
			case 'altas':
				$alumno=new Alumno();
				require_once("views/capturar_alumno.php");
			break;
			case 'calificaciones':
				$calif=new Calificacion();
				require_once("views/capturar_calif.php");
			break;
			case 'seccion_alumnos':
				require_once("views/seccion_alumnos.php");
			break;
			default:
				require_once("views/error_message.php");;
		}
	}
	
	handler();
?>