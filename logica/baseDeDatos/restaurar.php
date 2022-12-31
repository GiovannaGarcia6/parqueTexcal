
<?php
	session_start();
	require '../../datos/baseDeDatos/restaurar.php';
	$id=$_POST['id'];//Se obtiene el id del administrador
	//Se obtinen las credenciales de la base de datos
	$servidor = $_POST['servidor'];
	$usuario = $_POST['usuario'];
	$password = $_POST['password'];
	$bd = $_POST['bd'];
    $archivo = $_FILES['archivo']['name'];
	$extension = pathinfo($archivo, PATHINFO_EXTENSION);

	if($servidor==="" || $usuario==="" || $bd==="" || $archivo === '' || $archivo === null){
		echo 2;
		exit();
	}else{
		if($servidor==="localhost" && $usuario==="root" && $password==="" && $bd==="parquetexcal"){
			// $file_type = $_FILES['archivo']['type'];

			if ($extension == 'sql') {
				//moving the uploaded sql file
				move_uploaded_file($_FILES['archivo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/backups/'.$archivo);
				$archivo_ubicacion = $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/backups/'.$archivo;

				//restore database using our function
				$restaurar = restaurarBD($servidor, $usuario, $password, $bd, $archivo_ubicacion);

				if($restaurar==1){
					unlink($archivo_ubicacion);
					echo 1;
					exit();
				}else{
					
					echo 0;
					exit();
				}
			}else{
				echo 3;
				exit();
			}
		}else{
			echo 4;
			exit();
		}
	}
?>
