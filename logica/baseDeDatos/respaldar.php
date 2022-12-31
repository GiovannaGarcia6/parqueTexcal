<?php
	session_start();
	require '../../datos/baseDeDatos/respaldar.php';
 
    $id=$_POST['id'];//Se obtiene el id del administrador

	//Se obtinen las credenciales de la base de datos
	$servidor = $_POST['server'];
	$usuario = $_POST['username'];
	$password = $_POST['password'];
	$bd = $_POST['dbname'];

	if($servidor==="localhost" && $usuario==="root" && $password==="" && $bd==="parquetexcal"){
 
		respaldarBD($servidor, $usuario, $password, $bd);
 
		exit();
		
	}else{
		$_SESSION['status'] = "Los datos ingresados son incorrectos, vuelva a intentar.";
        header("Location: ../../paginas/administrador/base de datos/respaldo.php?id=".$id);
	}
 
?>