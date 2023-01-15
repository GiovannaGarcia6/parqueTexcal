<?php
    /*  
        Nombre de la función: buscadorMantenimientos
        Entrada: Frase o palabra a buscar.
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */
    function buscadorMantenimientos($buscador){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //si el buscador esta vacío se crea un sql para mostrar los datos de los mantenimientos almacenados en la base de datos. 
            $sql = "SELECT idMantenimiento, nombreMant, descMant from Mantenimiento";
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla Tienda
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            $sql = "SELECT idMantenimiento, nombreMant, descMant from mantenimiento
            where idMantenimiento like '%".$buscador."%' or nombreMant like '%".$buscador."%' or descMant like '%".$buscador."%'";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retorna el resultado del la ejecución del query

        mysqli_close($conn);//Se cierra la conexión
    
    }

   /*  
        Nombre de la función: contarMantenimientosXNombre($nombre){
        Entrada: Nombre del mantenimiento.
        Salida: Se retorna el conteo

        Descripción: La función realiza un conteo a los registros de la base de datos los cuales cumplen con el 
        mismo nombre del mantenimiento.
    */
    function contarMantenimientosXNombre($nombre){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza el conteo de los mantenimientos con el nombre que se indicó.
        $sql  = "SELECT count(*) as contar from mantenimiento where nombreMant = '".$nombre."'";
        
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado en un array
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el contador

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: agregarMantenimiento
        Entrada: Nombre y descripción del mantenimiento
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de un nuevo mantenimiento con los datos enviados por el usuario.
    */
    function agregarMantenimiento($nombre, $descripcion){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into mantenimiento(idMantenimiento,nombreMant,descMant) values (null,'".$nombre."','".$descripcion."')";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: editarMantenimiento
        Entrada: Nombre, descripción y id del mantenimiento
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la información del mantenimiento con los datos enviados por el usuario.
    */
    function editarMantenimiento($nombre, $descripcion, $idMantenimiento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query="UPDATE Mantenimiento SET  nombreMant = '".$nombre."', descMant = '".$descripcion."' WHERE idMantenimiento='".$idMantenimiento."'";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }
    
    /*  
        Nombre de la función: eliminarMantenimiento
        Entrada: id del mantenimiento
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un mantenimiento indicado por el usuario y si esta cuenta con tareas también 
        son eliminadass.
    */
    function eliminarMantenimiento($idMantenimiento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para realizar la eliminación de las tareas de dicho mantenimiento
        $queryTareas = "DELETE FROM Tarea WHERE idMantenimiento='".$idMantenimiento."'";

        //Query que realiza la eliminación del mantenimiento
        $queryMantenimiento="DELETE FROM Mantenimiento WHERE idMantenimiento='".$idMantenimiento."'";

        //Se ejecuta el query
        if(($conn->query($queryTareas) === TRUE) && ($conn->query($queryMantenimiento) === TRUE)){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: buscadortareas
        Entrada: Frase o palabra a buscar y id del mantenimiento
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        las tareas de un mantenimiento que cumplan con las condiciones.
    */
    function buscadortareas($buscador,$idMantenimiento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "SELECT idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm, correoTrab from Tarea INNER JOIN Trabajador on Trabajador.idTrabajador=Tarea.idTrabajador where idMantenimiento=".$idMantenimiento;

        }else{
            $sql = "SELECT idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm, correoTrab from tarea INNER JOIN Trabajador on Trabajador.idTrabajador=Tarea.idTrabajador
            where idTarea like '%".$buscador."%' or tituloTarea like '%".$buscador."%' or descTarea like '%".$buscador."%' or estadoTarea like '%".$buscador."%' or fechInic like '%".$buscador."%' or correoTrab like '%".$buscador."%' and idMantenimiento=$idMantenimiento";
                        
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    /*  
        Nombre de la función: buscadorTareasEmpleado
        Entrada: Frase o palabra a buscar y id del empleado
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        las tareas de un empleado que cumplan con las condiciones.
    */
    function buscadorTareasEmpleado($buscador,$idEmpleado){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que el buscador este vacio, se crea un sql para mostrar los datos de las tareas de un empleado almacenadas en la base de datos.
            $sql = "SELECT idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm from Tarea where idTrabajador =".$idEmpleado." and estadoTarea !='Finalizada' order by estadoTarea";

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla tarea
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            $sql = "SELECT idTarea, tituloTarea, descTarea, estadoTarea, fechInic, fechTerm from tarea
            where (idTarea like '%".$buscador."%' or tituloTarea like '%".$buscador."%' or descTarea like '%".$buscador."%' or estadoTarea like '%".$buscador."%' or fechInic like '%".$buscador."%' ) and idTrabajador= ".$idEmpleado." and estadoTarea !='Finalizada' order by estadoTarea";         
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retornan los registros

        mysqli_close($conn);//Se cierra la conexión
    
    }

    
    /*  
        Nombre de la función: contarTareasXTituloID
        Entrada: Titulo y id del mantenimiento
        Salida: Resultado del conteo

        Descripción: La función realiza un conteo a los registros que tengan el mismo titulo de la tarea y el id del mantenimiento.
    */
    function contarTareasXTituloID($titulo, $idMantenimiento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para contar los resgistros que tengan el mismo titulo y id del mantenimiento
        $query  = "SELECT count(*) as contar from tarea where tituloTarea = '".$titulo."' and idMantenimiento = '".$idMantenimiento."'";
        
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $query);

        //Se almacena el resultado en un array
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el contador

        mysqli_close($conn);//Se cierra la conexión
    }

    
    /*  
        Nombre de la función: agregarLocalobtenerIdTrabajadorXCorreo
        Entrada: Correo del trabajador
        Salida: Id del trabajador

        Descripción: La función realiza una consulta a la tabla trabajador para obtener el id del trabajador al que corresponda el correo.
    */
    function obtenerIdTrabajadorXCorreo($correo){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que obtiene el id del trabajador con ayuda del correo
        $query = "SELECT idTrabajador from Trabajador where correoTrab = '".$correo."'";  

        //Se ejecuta el query
        $resultado = mysqli_query($conn, $query);

        //Se almacena los datos
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['idTrabajador']; //se retorna el id del trabajador

        mysqli_close($conn);//Se cierra la conexión
    }


    /*  
        Nombre de la función: agregarTarea
        Entrada: Titulo de la tarea, descripción, estado, fecha de inicio, fecha de termino, id del trabajador, id de la tarea y id del mantenimiento
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de una nueva tarea con los datos enviados por el usuario.
    */
    function agregarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idMantenimiento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Tarea(idTarea,tituloTarea,descTarea,estadoTarea,fechInic,fechTerm,idTrabajador,idMantenimiento) values (null,'".$titulo."','".$desc."','".$estado."',adddate(FROM_UNIXTIME('".$fechInic."'),interval 1 day),adddate(FROM_UNIXTIME('".$fechTerm."'),interval 1 day),'".$idTrab."',".$idMantenimiento.")"; 
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: consultarTrabajadores
        Entrada: sin parametros
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una consulta a la base de datos de los trabajadores que sean de tipo mantenimiento.
    */
    function consultarTrabajadores(){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para realizar una consulta de todos los trabajadores de mantenimiento
        $consulta = "SELECT * from trabajador where tipoTrab='Mantenimiento'";

        //Se ejecuta el query
        $ejecutar=mysqli_query($conn,$consulta);

        return $ejecutar; //Se retorna el resultado
        
        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: editarTarea
        Entrada: Titulo de la tarea, descripción, estado, fecha de inicio, fecha de termino, id del trabajador y id de la tarea
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la información de la tarea de mantenimiento con los datos enviados por el usuario.
    */
    function editarTarea($titulo, $desc, $estado, $fechInic, $fechTerm, $idTrab, $idTarea){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la actualizacion de los datos cuando todos son correctos.
        $query="UPDATE Tarea SET  tituloTarea = '".$titulo."', descTarea = '".$desc."', estadoTarea = '".$estado."', fechInic = adddate(FROM_UNIXTIME('".$fechInic."'),interval 1 day) , fechTerm = adddate(FROM_UNIXTIME('".$fechTerm."'),interval 1 day) , idTrabajador = '".$idTrab."' WHERE idTarea='".$idTarea."'";        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: eliminarTarea
        Entrada: Id de la tarea
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de una tarea indicada por el usuario.
    */
    function eliminarTarea($idTarea){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query = "DELETE FROM Tarea WHERE idTarea='".$idTarea."'";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: cambiarEstadoTarea
        Entrada: Id de la tarea, estado de la tarea(1 = Finalizzada, 2 = En proceso)
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización en el cambio de estado de la tarea.
    */
    function cambiarEstadoTarea($idTarea,$estado){ 
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //si el estado es igual a 1 cambiará el estado a finalizada
        if($estado === '1'){
            $query =  "UPDATE Tarea SET estadoTarea='Finalizada' WHERE idTarea='".$idTarea."'";
        }else{
            //Sino cambiará al estado de en proceso
            $query =  "UPDATE Tarea SET estadoTarea='En proceso' WHERE idTarea='".$idTarea."'";
        }
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }
?>