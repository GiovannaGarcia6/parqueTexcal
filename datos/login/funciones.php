<?php
    /*  
        Nombre de la función: existeUsuario
        Entrada: Correo, contraseña, el campo por el cual se va a realizar la consulta y el tipo de usuario
        Salida: El resultado de contabilizar los registros

        Descripción: La función permite realizar una consulta para saber si existe un usuario, ya sea 
        visitante o trabajador. Esta puede ser ralizada por el correo, el id o correo y contraseña. 
        Una vez realizada la consulta se obtendrá un dato que indica el número de registros con los que
        coincidio la búsqueda. 
    */
    function existeUsuario($campo1,$campo2, $campoBuscar,$tipoUsuario){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se verifica el tipo de usuario
        if($tipoUsuario === "Visitante"){
            //se verifica el campo a buscar
            if($campoBuscar === "Correo"){
                //Se realiza un conteo de cuantos visitantes tienen el mismo correo.
                $sql  = "SELECT count(*) as contar from visitante where correoVisit = '".$campo1."'";
            }else{
                if($campoBuscar === "ID"){
                    //Se realiza un conteo de cuantos visitantes tienen el mismo is.
                    $sql  = "SELECT count(*) as contar from visitante where idVisitante = '".$campo1."'";
                }else{
                    //Se realiza un conteo de cuantos visitantes tienen el mismo correo y contraseña
                    $sql  = "SELECT count(*) as contar from visitante where correoVisit = '" . $campo1 . "' and contraVisit = md5('".$campo2."')";
                }
            }    
        }else{
            if($campoBuscar === "Correo"){
                //Se realiza un conteo de cuantos viistantes tienen el mismo correo.
                $sql  = "SELECT count(*) as contar from Trabajador where correoTrab = '".$campo1."'";
            }else{
                if($campoBuscar === "ID"){
                    //Se realiza un conteo de cuantos trabajadores tienen el mismo id.
                    $sql  = "SELECT count(*) as contar from Trabajador where idTrabajador = '".$campo1."'";
                }else{
                    //Se realiza un conteo de cuantos trabajadores tienen el mismo correo y contraseña.
                    $sql  = "SELECT count(*) as contar from Trabajador where correoTrab = '" . $campo1 . "' and contraTrab = md5('".$campo2."')";
                }
            }  

        }
        
        //Ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Almacenamiento de la variable 
        $array = mysqli_fetch_array($consulta);

        //Se retorna el contador
        return $array['contar'];
        
        mysqli_close($conn);//Se cierra la conexión

    }

    /*
        Nombre de la función: consultarTipoTrabajador
        Entrada: correo y contraseña
        Salida: tipo de trabajador

        Descripción: La función permite consultar el tipo de un trabajador, para ello necesita el usuario y 
        contraseña.
    */
    function consultarTipoTrabajador($correo, $contrasena){

        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        //Se realiza un consulta para saber el tipo de trabajador que coincida con los datos enviados
        $datos = "SELECT tipoTrab from Trabajador where correoTrab = '" . $correo . "' and contraTrab= md5('".$contrasena."')";
        
        //Se ejecuta la sentencia sql
        $result = mysqli_query($conn, $datos);
        
        while ($row = mysqli_fetch_row($result)){
            //Se asigna el tipo de trabajador que se encontro.
            $tipo = $row[0];
        }
        
        return $tipo; //Se retorna el tipo de trabajador

        mysqli_close($conn); //Se cierra la conexión
    }

    /*
        Nombre de la función: registrarVisitante
        Entrada: nombre, apellido paterno, apellido materno, correo y contraseña
        Salida: Resultado de la ejecución del query, este puede ser un 1 o un 0

        Descripción: Esta función permite realizar la inserción de un nuevo visitante. Cuando se realiza la 
        ejecución del query esté puede retorna un 1 si fue exitoso o un 0 si ocurrió un error.
    */
    function registrarVisitante($nombre, $apellidoMaterno, $apellidoPaterno, $correo, $contrasena){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Visitante (nombVisit,apellPatVisit,apellMatVisit,correoVisit,contraVisit) values ('".$nombre."','".$apellidoPaterno."','".$apellidoMaterno."','".$correo."',md5('".$contrasena."'))";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: sesion
        Entrada: correo del usuario y tipo de usuario
        Salida: id del usuario

        Descripción: Esta función permite obtener el id de un visitante o un trabajador
    */
    function sesion($usuario, $tipoUsuario){

        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        //Se identifaca el tipo de usuario para hacer uso del query correspondiente y ontener el id del usuario
        if($tipoUsuario === "Visitante"){
            $sql = "SELECT idVisitante from Visitante where correoVisit = '" . $usuario . "'";

        }else{
            $sql = "SELECT idTrabajador from Trabajador where correoTrab = '" . $usuario . "'";
        }

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            //se crea la variable de sesión
            $_SESSION['usuario'] = $row['0'];
            $idUsuario =  $row['0'];
        }

        return $idUsuario; //Se retorna el id

        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: obtenerDatos
        Entrada: Dato que se va a buscar(Correo o id cel usuario), campo por el que se va a buscar y tipo de usuario
        Salida: Resultado de la consulta, este retornará los registros que coincidan.

        Descripción: La función realiza la obtención de datos del usuario que coincida con los datos proporcionados.
    */
    function obtenerDatos($campo,$campoBuscar, $tipoUsuario){
        
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
       
        //Se identifica el tipo de usuario y el campo a buscar para así usar el query correspondiente para 
        //realizar la consulta y obtener los datos
        if($tipoUsuario === "Visitante"){

            if($campoBuscar === "Correo"){
                $buscar=mysqli_query($conn,"SELECT idVisitante, nombVisit from Visitante WHERE correoVisit = '".$campo."'");
            }else{
                $buscar=mysqli_query($conn,"SELECT correoVisit, nombVisit from Visitante WHERE idVisitante = '".$campo."'");
            }

        }else{
            
            if($campoBuscar === "Correo"){
                $buscar=mysqli_query($conn,"SELECT idTrabajador, nombreTrab from Trabajador WHERE correoTrab = '".$campo."'");
            }else{
                $buscar=mysqli_query($conn,"SELECT correoTrab, nombreTrab from Trabajador WHERE idTrabajador = '".$campo."'");
            }
        }
        //Se crea un query para obtener los datos del visitante.
        $datos=mysqli_fetch_array($buscar);
        
        return $datos; //Se retornan los datos
        
        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: actualizarContrasena
        Entrada: id del usuario, la nueva contraseña y el tipo de usuario.
        Salida: Resultado de la ejecución del query, este puede ser un 1 o un 0.

        Descripción: La función realiza la actualización de la nueva contraseña, esta puede ser realizada 
        dependiendo del tipo de usuario que solicito la acción. Una vez que sea ejecutada, retornará 1 si 
        la ejecución fue exitosa y un 0 si hubo un error en la ejecución.
    */
    function actualizarContrasena($id,$contrasena,$tipoUsuario){
        
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        //Se identifica al tipo de usuario para usar el query correspondiente y realizar la actualización de la contraseña
        if($tipoUsuario === "Visitante"){
            $query="UPDATE Visitante SET  contraVisit =  md5('".$contrasena."') where idVisitante = ".$id;
        }else{
            $query="UPDATE Trabajador SET  contraTrab = md5('".$contrasena."') where idTrabajador = ".$id;
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
