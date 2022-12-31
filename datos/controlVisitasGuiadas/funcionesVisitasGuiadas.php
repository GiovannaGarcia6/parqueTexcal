<?php
    function consultarTrabajadores(){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $consulta="SELECT * from trabajador where tipoTrab='Guia'";
        $ejecutar=mysqli_query($conn,$consulta);

        return $ejecutar;
        
        mysqli_close($conn);//Se cierra la conexión

    }

    function obtenerIdTrabajadorXCorreo($correo){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "SELECT idTrabajador from Trabajador where correoTrab = '".$correo."'";  
        $resultado = mysqli_query($conn, $query);
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['idTrabajador'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function visitasEnEspera($idVisitante){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from visitaGuiada where idVisitante = '".$idVisitante."' and estadoVisi = 'En espera'";
        $resultado = mysqli_query($conn, $query);
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }


    function agregarVisita($fecha, $idVisitante, $idTrab){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into visitaGuiada(idVisitaGuiada,fechVisi,estadoVisi,idVisitante,idTrabajador) values (null,adddate(FROM_UNIXTIME('".$fecha."'),interval 1 day),'En espera',".$idVisitante.",".$idTrab.")"; 
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }


    function buscadorVisitas($buscador,$id,$estadoVisita){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "Select idVisitaGuiada,fechVisi,estadoVisi, correoTrab from visitaGuiada INNER JOIN Trabajador on Trabajador.idTrabajador=visitaGuiada.idTrabajador
            where idVisitante= ".$id." and estadoVisi='".$estadoVisita."'";


        }else{
            $sql = "Select idVisitaGuiada,fechVisi, estadoVisi, correoTrab from visitaGuiada INNER JOIN Trabajador on Trabajador.idTrabajador=visitaGuiada.idTrabajador
            where fechVisi like '%".$buscador."%' or correoTrab like '%".$buscador."%' and idVisitante= ".$id." and estadoVisi='".$estadoVisita."'";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function buscadorVisitasGuia($buscador,$id,$estadoVisita){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "Select idVisitaGuiada, fechVisi, correoVisit from visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante
            where idTrabajador= ".$id." and estadoVisi='".$estadoVisita."'";

        }else{
            $sql = "Select idVisitaGuiada, fechVisi, correoVisit from visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante
            where fechVisi like '%".$buscador."%' or correoVisit like '%".$buscador."%' and idTrabajador= ".$id." and estadoVisi='".$estadoVisita."'";
            
            
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }


    function cancelarVisita($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        $idChat = obtenerIdChat($idVisita);
        
        $query1 = "DELETE FROM mensaje WHERE idChat =".$idChat; 
        $query2 = "DELETE FROM chat WHERE idVisitaGuiada=".$idVisita; 
        $query3 = "DELETE FROM visitaGuiada WHERE idVisitaGuiada=".$idVisita;
        //Se realiza un query 
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina de taquilla.
        
        if(($conn->query($query1) === TRUE) && ($conn->query($query2) === TRUE) && ($conn->query($query3) === TRUE)){  
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión

    }

    function obtenerCorreoVisitante($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
     
        $query = "SELECT correoVisit from visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante  WHERE idVisitaGuiada =".$idVisita;
        $resultado = mysqli_query($conn, $query);
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['correoVisit'];

        mysqli_close($conn);//Se cierra la conexión
    }


    function aceptarVisita($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        $query = "UPDATE visitaGuiada SET estadoVisi='Pendiente' WHERE idVisitaGuiada='".$idVisita."'";
        $query2 = "INSERT INTO chat(idChat,idVisitaGuiada) values (null,".$idVisita.")"; 

        if(($conn->query($query) === TRUE) && ($conn->query($query2) === TRUE)){  
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    
    function finalizarVisita($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $idChat = obtenerIdChat($idVisita);
        $query1 = "UPDATE visitaGuiada SET estadoVisi='Finalizada' WHERE idVisitaGuiada='".$idVisita."'";
        $query2 = "DELETE FROM mensaje WHERE idChat =".$idChat; 
        $query3 = "DELETE FROM chat WHERE idVisitaGuiada=".$idVisita; 

        if(($conn->query($query1) === TRUE) && ($conn->query($query2) === TRUE) && ($conn->query($query3) === TRUE)){  
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }


    function obtenerIdChat($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "SELECT idChat from chat where idVisitaGuiada = '".$idVisita."'";  
        $resultado = mysqli_query($conn, $query);
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['idChat'];

        mysqli_close($conn);//Se cierra la conexión
    }


    function rechazarVisita($idVisita){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        $query = "DELETE FROM visitaGuiada WHERE idVisitaGuiada=".$idVisita;
        //Se realiza un query 
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina de taquilla.
        
        if(($conn->query($query) === TRUE)){  
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión

    }
?>