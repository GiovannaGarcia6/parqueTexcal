<?php 
    
    //Archivo que nos permite acceder a las funciones del archivero
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

    session_start();//Se inicia la sesión.

    //Se obtienen y se limpian todos los datos que se mandaron al formulario
    $id =  htmlentities($_POST['id']);
    $idCarpeta =  htmlentities($_POST['idExp']);
    $nombreArchivo =  htmlentities($_POST['nombreArchivo']);
    $archivo = $_FILES['archivo']['name'];

    $nuevoNombreArchivo = null; //Se asigna un valor null ya que este cambiará cuando se le asigne el nuevo nombre al archivo

    //Se verifica que el archivo no este vacío
    if ($archivo != '' || $archivo != null) {
        //Se identifica el tipo de archivo 
        $file_type = $_FILES['archivo']['type'];
        list($type, $extension) = explode('/', $file_type);

        //Se verifica que el tipo de archivo sea pdf
        if ($extension == 'pdf') {
            //Se verifica si existen mas archivos con ese nombre en la misma carpeta
            $existe = contarArchivosXNombre($nombreArchivo, $idCarpeta);
            //Si es mayor a cero significa que ya existe y debe redirigirse a la página de agregar archivo
            if($existe > 0 ){
                $_SESSION['status'] = "El archivo ya existe.";
                header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
                exit();
            }else{
                
                $dir = '../../presentacion/archivosTemp/'; //Dirección de la carpeta de archivos temporales
                $nombreTemp = $_FILES['archivo']['tmp_name'];
                $nuevoNombreArchivo = $dir . nombreArchivo($nombreArchivo) . '.' . $extension;

                //Se copia el archivo a la carpeta archivosTemp que se encuentra en la capa de presentación
                if (copy($nombreTemp, $nuevoNombreArchivo)) {}
            
                //Se realiza la inserción de un nuevo registro
                $resultadoAgregar = agregarArchivo($nombreArchivo, $nuevoNombreArchivo, $idCarpeta);

                //Si el resultado retornado es igual a 1, el resgistro se agrego con éxito, sino hubo un error en el proceso
                if($resultadoAgregar === 1){
                    //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
                    $_SESSION['status'] = "Archivo agregado con éxito.";
                    //Se redirige a la interfaz de agregar archivo
                    header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
                }else{
                    //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
                    $_SESSION['status'] = "Hubo un error al agregar.";
                    //Se redirige a la interfaz de agregar archivo
                    header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
                }
            }
        }else{
            //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
            $_SESSION['status'] = "Los archivos deben de ser PDF.";
            //Se redirige a la interfaz de agregar archivo
            header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
        }
    }else{
        //Se crea la variable de sesión con el mensaje a mostrar en la interfaz
        $_SESSION['status'] = "No hay ningún archivo.";
        //Se redirige a la interfaz de agregar archivo
        header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
    }
?>

