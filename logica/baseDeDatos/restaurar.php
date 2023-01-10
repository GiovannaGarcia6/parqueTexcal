
<?php
	//Se inicia la sesión
	session_start();

	//Archivo que nos permite acceder a las funciones
	require '../../datos/baseDeDatos/restaurar.php';

	$id = htmlentities($_POST['id']);//Se obtiene el id del administrador

	//Se obtinen las credenciales de la base de datos
	$servidor = htmlentities($_POST['servidor']);
	$usuario = htmlentities($_POST['usuario']);
	$password = htmlentities($_POST['password']);
	$bd = htmlentities($_POST['bd']);
    $archivo = $_FILES['archivo']['name']; 
	$extension = pathinfo($archivo, PATHINFO_EXTENSION); //Se obtiene la extensión del archivo

	//Si los datos se encuentran vacíos se manda un 2 que con ajax nos permitirá mostrar el mensaje al usuario de lo que ocurrió
	if($servidor==="" || $usuario==="" || $bd==="" || $archivo === '' || $archivo === null){
		echo 2;
		exit();
	}else{
		//Si los datos proporcionados coninciden, se procede a llamar a la función que realizará la restauración de la BD.
		if($servidor==="localhost" && $usuario==="root" && $password==="" && $bd==="parquetexcal"){

			//Se verifica que el archivo que subió el usuario sea de tipo sql, ya que de otra manera se enviará un 3 
			//para que la capa de presentación muestre el mensaje correspondiente.
			if ($extension == 'sql') {
				//moving the uploaded sql file
				move_uploaded_file($_FILES['archivo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/backups/'.$archivo);
				$archivo_ubicacion = $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/backups/'.$archivo;

				//Se llama a la función restaurarBD que se encuentra en el archivo y se le envían los datos
				$restaurar = restaurarBD($servidor, $usuario, $password, $bd, $archivo_ubicacion);

				//Si el resultado obtenido es igual a 1, indica que todo fue exitoso 
				if($restaurar==1){
					//Se elimina el archivo sql
					unlink($archivo_ubicacion);

					//Se envía un 1 a la capa de presentación para mostrar el mensaje correspondiente.
					echo 1;
					exit();

				}else{
			
					//Se envía un 0 a la capa de presentación para mostrar el mensaje correspondiente.
					echo 0;
					exit();

				}
			}else{

				//Se envía un 3 a la capa de presentación para mostrar el mensaje correspondiente.
				echo 3;
				exit();

			}
		}else{

			//Se envía un 4 a la capa de presentación para mostrar el mensaje correspondiente.
			echo 4;
			exit();
			
		}
	}
?>
