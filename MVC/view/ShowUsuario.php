<?php
	echo "Informacion de USUARIO:<br><br>";
	echo "-------------------------------------------------------------------<br>";
	echo "....USUARIO....|...CLAVE...|...TIPO...|...STATUS...|......EMAIL......<br>";
	echo "-------------------------------------------------------------------<br>";
	//print_r($result);
	echo "....." . $result['usuario'] . ".....";
	echo "....." . $result['clave'] . ".....";
	echo "...." . $result['tipo_usuario'] . ".....";
	echo "...." . $result['status'] . ".....";
	echo "...." . $result['email'] . ".....";
	echo "<br>";
	
?>
