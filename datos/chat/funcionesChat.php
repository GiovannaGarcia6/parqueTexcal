<?php

    function nombreUsuarioChat($idVisita,$tipoUsuario){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        if($tipoUsuario === "Visitante"){
            $query = "SELECT nombVisit FROM visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante where idVisitaGuiada = '".$idVisita."'";  
            $resultado = mysqli_query($conn, $query);
            $datos = mysqli_fetch_assoc($resultado);
            return $datos['nombVisit'];
        }else{
            $query = "SELECT nombreTrab FROM visitaGuiada INNER JOIN trabajador on trabajador.idTrabajador=visitaGuiada.idTrabajador where idVisitaGuiada = '".$idVisita."'";  
            $resultado = mysqli_query($conn, $query);
            $datos = mysqli_fetch_assoc($resultado);
            return $datos['nombreTrab'];
        }
       
        
        mysqli_close($conn);//Se cierra la conexión

    }

    function idChat($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "SELECT idChat FROM chat where idVisitaGuiada = '".$idVisita."'";  
        $resultado = mysqli_query($conn, $query);
        $datos = mysqli_fetch_assoc($resultado);
        return $datos['idChat'];
        
        mysqli_close($conn);//Se cierra la conexión
    }

    function enviarMensaje($idVisita,$tipoUsuario,$msg){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $nombre = nombreUsuarioChat($idVisita,$tipoUsuario);
        $idChat = idChat($idVisita);
        $query  = "Insert into mensaje(idMensaje,nombre,mensaje,idChat) values (null,'".$nombre."','".$msg."',".$idChat.")"; 
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }


    function usuarioDestino($idVisita,$tipoUsuario){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        if($tipoUsuario === "Visitante"){
            $query = "SELECT nombVisit, apellPatVisit FROM visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante where idVisitaGuiada = '".$idVisita."'";  
        }else{
            $query = "SELECT nombreTrab, apellPatTrab FROM visitaGuiada INNER JOIN trabajador on trabajador.idTrabajador=visitaGuiada.idTrabajador where idVisitaGuiada = '".$idVisita."'";  
        }
        $resultado = mysqli_query($conn, $query);

        return  $resultado;
        
        mysqli_close($conn);//Se cierra la conexión

    }


    function consultarMensajes($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "SELECT * FROM mensaje INNER JOIN chat on chat.idChat=mensaje.idChat  WHERE idVisitaGuiada='".$idVisita."'";

        $resultado = mysqli_query($conn, $query);

        return  $resultado;
        
        mysqli_close($conn);//Se cierra la conexión
    }
?>