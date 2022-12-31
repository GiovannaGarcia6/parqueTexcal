<?php 
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

    session_start();//Se inicia la sesión.
    //Se obtienen todos los datos que se mandaron al formulario.

    $id =  htmlentities($_POST['id']);
    $idCarpeta =  htmlentities($_POST['idExp']);
    $nombreArchivo =  htmlentities($_POST['nombreArchivo']);
    $archivo = $_FILES['archivo']['name'];

    $new_name_file = null;

    if ($archivo != '' || $archivo != null) {
        $file_type = $_FILES['archivo']['type'];
        list($type, $extension) = explode('/', $file_type);
        if ($extension == 'pdf') {
           $existe = contarArchivosXNombre($nombreArchivo, $idCarpeta);
            //Si es mayor a cero significa que la clave ya existe y debe redirigirse a la página de registrar.
            if($existe > 0 ){
                $_SESSION['status'] = "El archivo ya existe.";
                header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
                exit();
            }else{
            
                $dir = '../../presentacion/archivosTemp/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $file_tmp_name = $_FILES['archivo']['tmp_name'];
                //$new_name_file = 'files/' . date('Ymdhis') . '.' . $extension;
                $new_name_file = $dir . nombreArchivo($nombreArchivo) . '.' . $extension;
                if (copy($file_tmp_name, $new_name_file)) {
                    
                }
            
                $resultadoAgregar = agregarArchivo($nombreArchivo, $new_name_file, $idCarpeta);
                if($resultadoAgregar === 1){
                    $_SESSION['status'] = "Archivo agregado con éxito.";
                    header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
                }else{
                    //Se manda el mensaje de error y se redirigirse a la página de registrar.
                    $_SESSION['status'] = "Hubo un error al agregar.";
                    header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
                }
            }
        }else{
            //Se manda el mensaje de error y se redirigirse a la página de registrar.
            $_SESSION['status'] = "Los archivos deben de ser PDF.";
            header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
        }
    }else{
        //Se manda el mensaje de error y se redirigirse a la página de registrar.
        $_SESSION['status'] = "No hay ningún archivo.";
        header("Location: ../../presentacion/administrador/archivero/archivos/agregarArchivo.php?id=".$id."&idExp=".$idCarpeta);
    }

    
    mysqli_close($conn);//Se cierra la conexión
?>