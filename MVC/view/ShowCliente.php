<?php
	echo "Informacion del CLIENTE:<br><br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "......IDCLIENTE........|....NOMBRE....|...APELLIDOS...|......DOMICILIO........|...TELEFONO...|...USUARIO...|<br>";
	echo "---------------------------------------------------------------------------------------------------------------------------------------<br>";
	echo "...." . $result['idCliente'] . ".....";
	echo "....." . $result['nombre'] . ".....";
	echo "....." . $result['apellidos'] . ".....";
	echo "...." . $result['domicilio'] . ".....";
	echo "...." . $result['telefono'] . ".....";
	echo "...." . $result['usuario'] . ".....";
	echo "<br>";
	
?>
