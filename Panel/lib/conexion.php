<?php
	$con = mysqli_connect("localhost", "usuprincipal", "abc123","panel");
	
	mysqli_set_charset($con, 'utf8');

	if (mysqli_connect_errno()){
		die('Fallo en la conexión: '. mysqli_connect__error());
	}
?>