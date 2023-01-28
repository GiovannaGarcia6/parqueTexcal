<?php
    /*
        Nombre de la función: mostrarComentarios
        Entrada: id del servicio
        Salida: Resultado de los datos obtenidos

        Descripción: Esta función se encarga de consultar los datos de los comentarios sobre un servicio o por la puntuación, esto dependera del filtro 
        que el usuario indique.
    */
    function mostrarComentarios($servicio, $filtro){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //De acuerdo al filtro y al servicio elegido, este va a utilizar el query correspondiente para realizar la consulta a los comentarios
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

        return  $resultado;//Se retornan los datos obtenidos de la consulta

        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: contarComentariosPositivos
        Entrada: id del servicio
        Salida: Resultado del conteo

        Descripción: Esta función se encarga de contabilizar los comentarios positivos de un servicio o de todos los servicios.
    */
    function contarComentariosPositivos($servicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Este query es para contabilizar los comentarios positivos, estos son aquellos que tengan una puntuación mayor o igual a 3
        if($servicio === "5"){
            $sql  = "SELECT count(*) as Positivos from Comentario where puntuacion >=3";
        }else{
            $sql  = "SELECT count(*) as Positivos from Comentario where puntuacion >=3 and idServicio = $servicio ";
        }
        
        //Se ejecuta el query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);
 
        return $array['Positivos']; //Se retorna el conteo de los comentarios positivos
 
        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: contarComentariosNegativos
        Entrada: id del servicio
        Salida: Resultado del conteo

        Descripción: Esta función se encarga de contabilizar los comentarios negativos de un servicio o de todos los servicios.
    */
    function contarComentariosNegativos($servicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Este query es para contabilizar los comentarios negativos, estos son aquellos que tengan una puntuación menor a 3
        if($servicio === "5"){
            $sql  = "SELECT count(*) as Negativos from Comentario where puntuacion <3";
        }else{
            $sql  = "SELECT count(*) as Negativos from Comentario where puntuacion <3 and idServicio = $servicio ";
        }
        
        //Se ejecuta el query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);
 
        return $array['Negativos']; //Se retorna el conteo de los comentarios negativos
 
        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: mostrarMantenimientos
        Entrada: Fecha de inicio y fecha de termino
        Salida: Resultado de la consulta
        Descripción: Esta función se encarga de obtener los datos de las tareas en un rango específico
    */
    function mostrarMantenimientos($fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Query que realiza una consulta de las tareas de los mantenimientos
        $sql = "SELECT nombreMant, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm from Mantenimiento inner join Tarea on Mantenimiento.idMantenimiento = Tarea.idMantenimiento where fechInic BETWEEN '".$fechaInicio."' AND '".$fechaTermino."' order by estadoTarea";

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: contarTareas
        Entrada: Estado de la tarea, fecha de inicio y fecha de termino
        Salida: Resultado del conteo

        Descripción: Esta función se encarga de contabilizar las tareas que cumplan con el estado y el rando de fechas
    */
    function contarTareas($estado, $fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza el conteo de las tareas en cuanto a un estado y a un rango de fechas
        $sql  = "SELECT count(*) as contarTareas from Tarea where estadoTarea = '$estado' and fechInic BETWEEN '".$fechaInicio."' AND '".$fechaTermino."'";
      
        //Se ejecuta el query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);

        return $array['contarTareas']; //Se retorna el conteo de las tareas
 
        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: mejorEmpleado
        Entrada: Fecha de inicio y fehca de termino
        Salida: Datos del empleado

        Descripción: Esta función se encarga de obtener los datos y contabilizar las tareas para asi obtener al mejor empleado que realizo
        el mayor número de tareas en el rango de fechas.
     */
    function mejorEmpleado($fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que obtiene los datos del mejor empleado de un rango de fechas
        $sql  = "SELECT nombreTrab, apellPatTrab, apellMatTrab, correoTrab, count(*) as contarTareasFinalizadas from Tarea inner join Trabajador on trabajador.idTrabajador = Tarea.idTrabajador where (estadoTarea = 'Finalizada') and (fechInic BETWEEN '".$fechaInicio."' AND '".$fechaTermino."')";
      
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);
       
        return $consulta; //Se retorna el resultado
 
        mysqli_close($conn);//Se cierra la conexión
    }
    

    /*
        Nombre de la función: mostrarVisitas
        Entrada: Id del guía, fecha de inicio y fehca de termino
        Salida: Datos de la visita

        Descripción: Esta función se encarga de obtener los datos de todas las visitas realizadas en un rango de fechas.
    */
    function mostrarVisitas($idGuia, $fechaInicio, $fechaTermino){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Query que obtiene los datos de las visitas guiadas
        $sql = "SELECT fechVisi, estadoVisi, nombVisit, apellPatVisit, apellMatVisit, correoVisit from Visitaguiada inner join Visitante on Visitaguiada.idVisitante = Visitante.idVisitante where estadoVisi = 'Finalizada' and idTrabajador = $idGuia and fechVisi BETWEEN '".$fechaInicio."' AND '".$fechaTermino."' order by fechVisi";

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: contarVisitas
        Entrada: Estdo de la visita, id del guía, fecha de inicio y fehca de termino
        Salida: Conteo de registros

        Descripción: Esta función se encarga de contabilizar las visitas guiadas de un guia en específico y que cumpla con el estado
        de la visita y del rango de fechas.
    */
    function contarVisitas($estado, $fechaInicio, $fechaTermino, $idGuia){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza el conteo de las visitas guiadas en cuanto al estado, al trabajador y al rango de fechas indicado
        $sql  = "SELECT count(*) as contarVisitas from Visitaguiada where estadoVisi = '$estado' and idTrabajador = $idGuia and fechVisi BETWEEN '".$fechaInicio."' AND '".$fechaTermino."'";
      
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);
        
        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);

        return $array['contarVisitas']; //Se retorna el conteo de las visitas guiadas
 
        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: contarTodasVisitas
        Entrada:id del guía, fecha de inicio y fehca de termino
        Salida: Conteo de registros

        Descripción: Esta función se encarga de contabilizar las visitas guiadas de un guia en específico y que cumpla con el rango de fechas indicado.
        
    */
    function contarTodasVisitas($fechaInicio, $fechaTermino, $idGuia){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza el conteo de todas las visitas guiadas de un trabajador en un rango de fechs
        $sql  = "SELECT count(*) as contarVisitas from Visitaguiada where idTrabajador = $idGuia and fechVisi BETWEEN '".$fechaInicio."' AND '".$fechaTermino."'";
      
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
 
        return $array['contarVisitas']; //Se retorna el conteo de las visitas
 
        mysqli_close($conn);//Se cierra la conexión
    }
    
    
?>