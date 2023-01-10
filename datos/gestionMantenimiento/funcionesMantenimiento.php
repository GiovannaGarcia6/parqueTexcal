<?php
    function buscadorMantenimientos($buscador){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "Select idMantenimiento, nombreMant, descMant from Mantenimiento";

        }else{
            $sql = "Select idMantenimiento, nombreMant, descMant from mantenimiento
            where idMantenimiento like '%".$buscador."%' or nombreMant like '%".$buscador."%' or descMant like '%".$buscador."%'";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }


    function contarMantenimientosXNombre($nombre){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "Select count(*) as contar from mantenimiento where nombreMant = '".$nombre."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function agregarMantenimiento($nombre, $descripcion){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into mantenimiento(idMantenimiento,nombreMant,descMant) values (null,'".$nombre."','".$descripcion."')";
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    function editarMantenimiento($nombre, $descripcion, $idMantenimiento){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query="UPDATE Mantenimiento SET  nombreMant = '".$nombre."', descMant = '".$descripcion."' WHERE idMantenimiento='".$idMantenimiento."'";
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    
    function eliminarMantenimiento($idMantenimiento){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        $queryTareas = "DELETE FROM Tarea WHERE idMantenimiento='".$idMantenimiento."'";

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $queryMantenimiento="DELETE FROM Mantenimiento WHERE idMantenimiento='".$idMantenimiento."'";
        
        if($conn->query($queryTareas) === TRUE){
            if($conn->query($queryMantenimiento) === TRUE){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    function buscadortareas($buscador,$idMantenimiento){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "Select idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm, correoTrab from Tarea INNER JOIN Trabajador on Trabajador.idTrabajador=Tarea.idTrabajador where idMantenimiento=".$idMantenimiento;

        }else{
            $sql = "SELECT idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm, correoTrab from tarea INNER JOIN Trabajador on Trabajador.idTrabajador=Tarea.idTrabajador
            where idTarea like '%".$buscador."%' or tituloTarea like '%".$buscador."%' or descTarea like '%".$buscador."%' or estadoTarea like '%".$buscador."%' or fechInic like '%".$buscador."%' or correoTrab like '%".$buscador."%' and idMantenimiento=$idMantenimiento";
                        
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function buscadorTareasEmpleado($buscador,$idEmpleado){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "Select idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm from Tarea where idTrabajador =".$idEmpleado." and estadoTarea !='Finalizada' order by estadoTarea";

        }else{
            $sql = "Select idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm from tarea
            where (idTarea like '%".$buscador."%' or tituloTarea like '%".$buscador."%' or descTarea like '%".$buscador."%' or estadoTarea like '%".$buscador."%' or fechInic like '%".$buscador."%' ) and idTrabajador= ".$idEmpleado." and estadoTarea !='Finalizada' order by estadoTarea";
                   
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }


    function contarTareasXTituloID($titulo, $idMantenimiento){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query  = "Select count(*) as contar from tarea where tituloTarea = '".$titulo."' and idMantenimiento = '".$idMantenimiento."'";
        $consulta =  mysqli_query($conn, $query);
        $array = mysqli_fetch_array($consulta);
    
        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function obtenerIdTrabajadorXCorreo($correo){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "Select idTrabajador from Trabajador where correoTrab = '".$correo."'";  
        $resultado = mysqli_query($conn, $query);
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['idTrabajador'];

        mysqli_close($conn);//Se cierra la conexión
    }


    function agregarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idMantenimiento){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Tarea(idTarea,tituloTarea,descTarea,estadoTarea,fechInic,fechTerm,idTrabajador,idMantenimiento) values (null,'".$titulo."','".$desc."','".$estado."',adddate(FROM_UNIXTIME('".$fechInic."'),interval 1 day),adddate(FROM_UNIXTIME('".$fechTerm."'),interval 1 day),'".$idTrab."',".$idMantenimiento.")"; 
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    function consultarTrabajadores(){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $consulta="SELECT * from trabajador where tipoTrab='Mantenimiento'";
        $ejecutar=mysqli_query($conn,$consulta);

        return $ejecutar;
        
        mysqli_close($conn);//Se cierra la conexión

    }

    function editarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idTarea){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query="UPDATE Tarea SET  tituloTarea = '".$titulo."', descTarea = '".$desc."', estadoTarea = '".$estado."', fechInic = adddate(FROM_UNIXTIME('".$fechInic."'),interval 1 day) , fechTerm = adddate(FROM_UNIXTIME('".$fechTerm."'),interval 1 day) , idTrabajador = '".$idTrab."' WHERE idTarea='".$idTarea."'";        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    function eliminarTarea($idTarea){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query = "DELETE FROM Tarea WHERE idTarea='".$idTarea."'";
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    function cambiarEstadoTarea($idTarea,$estado){ 
        
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($estado === '1'){
            $query =  "UPDATE Tarea SET estadoTarea='Finalizada' WHERE idTarea='".$idTarea."'";
        }else{
            $query =  "UPDATE Tarea SET estadoTarea='En proceso' WHERE idTarea='".$idTarea."'";
        }
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión

    }
   
?>