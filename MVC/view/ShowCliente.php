<?php
	echo "Informacion del CLIENTE:<br><br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "......ID........|....NOMBRE....|...AP. PATERNO...|...AP. MATERNO...|......DOMICILIO........|...TELEFONO...|...CORREO...|...ID LOGIN...|<br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "...." . $result[$i]['id'] . ".....";
	echo "....." . $result[$i]['nombres'] . ".....";
	echo "....." . $result[$i]['apPaterno'] . ".....";
	echo "...." . $result[$i]['apMaterno'] . ".....";
	echo "...." . $result[$i]['domicilio'] . ".....";
	echo "...." . $result[$i]['telefono'] . ".....";
	echo "...." . $result[$i]['correo'] . ".....";
	echo "...." . $result[$i]['idLogin'] . ".....";
	echo "<br>";
	
?>
