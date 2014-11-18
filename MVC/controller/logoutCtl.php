<?php
	$logout=new LogoutCtl();
	$logout->logout();

	Class LogoutCtl{

		function logout(){
			session_start();
			session_unset();
			session_destroy();
			setcookie(session_name(), '', time()-3600);
			header('Location: ../index.html');
		}
	}
?>
