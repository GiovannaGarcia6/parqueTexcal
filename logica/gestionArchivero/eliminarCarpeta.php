<?php
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';
    session_start();
    $idCarpeta = $_GET['idExp'];
    $idAdmin = $_GET['idAdmin'];

    $resultadEliminar = eliminarCarpeta($idCarpeta);
    if($resultadEliminar === 1){
        $_SESSION['status'] = "Carpeta y archivos eliminados con éxito.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/archivero.php?id=".$idAdmin);
    }else{
        $_SESSION['status'] = "Hubo un error al eliminar.";
        header("Location: ../../presentacion/administrador/archivero/carpetas/archivero.php?id=".$idAdmin);
    }
?>