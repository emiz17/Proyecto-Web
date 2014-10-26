<?php
	echo "Informacion de USUARIO:<br><br>";
	echo "-------------------------------------------------------------------<br>";
	echo "......ID........|....USUARIO....|...CLAVE...|...TIPO...|...STATUS...|<br>";
	echo "-------------------------------------------------------------------<br>";
	//print_r($result);
	echo "...." . $result['id'] . ".....";
	echo "....." . $result['nomUsuario'] . ".....";
	echo "....." . $result['clave'] . ".....";
	echo "...." . $result['tipoUsuario'] . ".....";
	echo "...." . $result['status'] . ".....";
	echo "<br>";
	
?>
