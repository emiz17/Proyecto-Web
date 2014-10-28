<?php


class MailMdl{

	private $headers;
	private $driver;

	function __construct(){

		$host=$user=$pass=$db='';
		$this->headers = 'From: admin@websolutionsteam.cf' . "\r\n" .
    	'Reply-To: admin@websolutionsteam.cf' . "\r\n" .
    	'X-Mailer: PHP/' . phpversion();


		/*require_once("config.inc");
		$this->driver=new mysqli($host, $user, $pass, $db);
		if($this->driver->connect_errno)
			require_once("view/ShowErrorConexion.php");*/

	}//fin de constructor


	function getEmail($usuario){
			//se busca en la base de datos	
			$query="SELECT email FROM usuario WHERE usuario=\"$usuario\" ";

			$r=$this->driver->query($query);

			$row=$r->fetch_assoc();

			if($row===NULL)
				$row=FALSE;

			return $row['email'];

		}

	function sendEmail($usuario , $asunto, $mensaje){
		$to=$this->getEmail($usuario);

		if(mail($to, $asunto, $mensaje, $this->headers))
			echo "Mensaje enviado exitosamente.";
		else
			echo "Ocurrio un error al enviar el archivo";

	}//fin de function send

}//fin de clase


?>