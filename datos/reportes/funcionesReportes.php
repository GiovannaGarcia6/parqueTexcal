<?php
    
    function mostrarComentarios($servicio, $filtro){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        if($filtro === "Todos"){
            if($servicio === "5"){
                $sql = "SELECT nombServ, contenido, puntuacion from Comentario inner join Servicio on Comentario.idServicio = Servicio.idServicio order by nombServ";
            }else{
                $sql = "SELECT nombServ, contenido, puntuacion from Comentario inner join Servicio on Comentario.idServicio = Servicio.idServicio where comentario.idServicio = $servicio order by puntuacion";
            }
        }else{
            if($filtro === "Positivos"){
                if($servicio === "5"){
                    $sql = "SELECT nombServ, contenido, puntuacion from Comentario inner join Servicio on Comentario.idServicio = Servicio.idServicio where puntuacion>=3 order by nombServ";
                }else{
                    $sql = "SELECT nombServ, contenido, puntuacion from Comentario inner join Servicio on Comentario.idServicio = Servicio.idServicio where puntuacion>=3 and comentario.idServicio = $servicio order by puntuacion";
                }
            }else{
                if($servicio === "5"){
                    $sql = "SELECT nombServ, contenido, puntuacion from Comentario inner join Servicio on Comentario.idServicio = Servicio.idServicio where puntuacion<=2 order by nombServ";
                }else{
                    $sql = "SELECT nombServ, contenido, puntuacion from Comentario inner join Servicio on Comentario.idServicio = Servicio.idServicio where puntuacion<=2 and comentario.idServicio = $servicio order by puntuacion";
                }
            }
        }
       
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión
    }

    function contarComentariosPositivos($servicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($servicio === "5"){
            $sql  = "SELECT count(*) as Positivos from Comentario where puntuacion >=3";
        }else{
            $sql  = "SELECT count(*) as Positivos from Comentario where puntuacion >=3 and idServicio = $servicio ";
        }
        
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
 
        return $array['Positivos'];
 
        mysqli_close($conn);//Se cierra la conexión
    }

    function contarComentariosNegativos($servicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($servicio === "5"){
            $sql  = "SELECT count(*) as Negativos from Comentario where puntuacion <3";
        }else{
            $sql  = "SELECT count(*) as Negativos from Comentario where puntuacion <3 and idServicio = $servicio ";
        }
        
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
 
        return $array['Negativos'];
 
        mysqli_close($conn);//Se cierra la conexión
    }


    function mostrarMantenimientos($fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        

        $sql = "SELECT nombreMant, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm from Mantenimiento inner join Tarea on Mantenimiento.idMantenimiento = Tarea.idMantenimiento where fechInic BETWEEN '".$fechaInicio."' AND '".$fechaTermino."' order by estadoTarea";

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión
    }

    function contarTareas($estado, $fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

     
        $sql  = "SELECT count(*) as contarTareas from Tarea where estadoTarea = '$estado' and fechInic BETWEEN '".$fechaInicio."' AND '".$fechaTermino."'";
      
        
        
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
 
        return $array['contarTareas'];
 
        mysqli_close($conn);//Se cierra la conexión
    }

    function mejorEmpleado($fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

     
        $sql  = "SELECT nombreTrab, apellPatTrab, apellMatTrab, correoTrab, count(*) as contarTareasFinalizadas from Tarea inner join Trabajador on trabajador.idTrabajador = Tarea.idTrabajador where (estadoTarea = 'Finalizada') and (fechInic BETWEEN '".$fechaInicio."' AND '".$fechaTermino."')";
      
        
        $consulta =  mysqli_query($conn, $sql);
       
 
        return $consulta;
 
        mysqli_close($conn);//Se cierra la conexión
    }
    
    function mostrarVisitas($idGuia, $fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        $sql = "SELECT fechVisi, estadoVisi, nombVisit, apellPatVisit, apellMatVisit, correoVisit from Visitaguiada inner join Visitante on Visitaguiada.idVisitante = Visitante.idVisitante where estadoVisi = 'Finalizada' and idTrabajador = $idGuia and fechVisi BETWEEN '".$fechaInicio."' AND '".$fechaTermino."' order by fechVisi";

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión
    }

    function contarVisitas($estado, $fechaInicio, $fechaTermino, $idGuia){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

     
        $sql  = "SELECT count(*) as contarVisitas from Visitaguiada where estadoVisi = '$estado' and idTrabajador = $idGuia and fechVisi BETWEEN '".$fechaInicio."' AND '".$fechaTermino."'";
      
        
        
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
 
        return $array['contarVisitas'];
 
        mysqli_close($conn);//Se cierra la conexión
    }
    function contarTodasVisitas($fechaInicio, $fechaTermino, $idGuia){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

     
        $sql  = "SELECT count(*) as contarVisitas from Visitaguiada where idTrabajador = $idGuia and fechVisi BETWEEN '".$fechaInicio."' AND '".$fechaTermino."'";
      
        
        
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
 
        return $array['contarVisitas'];
 
        mysqli_close($conn);//Se cierra la conexión
    }
    
    
?>