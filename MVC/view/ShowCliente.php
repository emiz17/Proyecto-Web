<?php
	echo "Informacion del CLIENTE:<br><br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "......ID........|....NOMBRE....|...AP. PATERNO...|...AP. MATERNO...|......DOMICILIO........|...TELEFONO...|...CORREO...|...ID LOGIN...|<br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "...." . $result['id'] . ".....";
	echo "....." . $result['nombres'] . ".....";
	echo "....." . $result['apPaterno'] . ".....";
	echo "...." . $result['apMaterno'] . ".....";
	echo "...." . $result['domicilio'] . ".....";
	echo "...." . $result['telefono'] . ".....";
	echo "...." . $result['correo'] . ".....";
	echo "...." . $result['idLogin'] . ".....";
	echo "<br>";
	
?>
