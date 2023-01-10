<?php
	session_start();

	//Archivo que nos permite acceder a las funciones 
	require '../../datos/baseDeDatos/respaldar.php';
 
    $id = htmlentities($_POST['id']);//Se obtiene el id del administrador

	//Se obtinen las credenciales de la base de datos
	$servidor = htmlentities($_POST['server']);
	$usuario = htmlentities($_POST['username']);
	$password = htmlentities($_POST['password']);
	$bd = htmlentities($_POST['dbname']);

	//Si los datos proporcionados coninciden, se procede a llamar a la función que realizara el respaldo de la BD.
	if($servidor==="localhost" && $usuario==="root" && $password==="" && $bd==="parquetexcal"){
 
		respaldarBD($servidor, $usuario, $password, $bd); //Función que se encuentra en ../../datos/baseDeDatos/respaldar.php
 
		exit(); //Se termina el proceso
		
	}else{
		//Si los datos no fueron los correctos se crea una variable de sesión con el mensaje
		//que se mostrará al usuario
		$_SESSION['status'] = "Los datos ingresados son incorrectos, vuelva a intentar.";

		//Se redirige a la interfaz del formulario del respaldo
        header("Location: ../../paginas/administrador/base de datos/respaldo.php?id=".$id);
	}
 
?>