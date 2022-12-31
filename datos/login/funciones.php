<?php 
    function existeUsuario($campo1,$campo2, $campoBuscar,$tipoUsuario){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($tipoUsuario === "Visitante"){

            if($campoBuscar === "Correo"){
                //Se realiza un conteo de cuantos viistantes tienen el mismo correo.
                $sql  = "SELECT count(*) as contar from visitante where correoVisit = '".$campo1."'";
            }else{
                if($campoBuscar === "ID"){
                    //Se realiza un conteo de cuantos viistantes tienen el mismo correo.
                    $sql  = "SELECT count(*) as contar from visitante where idVisitante = '".$campo1."'";
                }else{
                    
                    $sql  = "SELECT count(*) as contar from visitante where correoVisit = '" . $campo1 . "' and contraVisit = md5('".$campo2."')";
                }
            }    
        }else{
            if($campoBuscar === "Correo"){
                //Se realiza un conteo de cuantos viistantes tienen el mismo correo.
                $sql  = "SELECT count(*) as contar from Trabajador where correoTrab = '".$campo1."'";
            }else{
                if($campoBuscar === "ID"){
                    //Se realiza un conteo de cuantos viistantes tienen el mismo correo.
                    $sql  = "SELECT count(*) as contar from Trabajador where idTrabajador = '".$campo1."'";
                }else{
                    $sql  = "SELECT count(*) as contar from Trabajador where correoTrab = '" . $campo1 . "' and contraTrab = md5('".$campo2."')";
                }
            }  

        }
        
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];
        
        mysqli_close($conn);//Se cierra la conexión

    }

    function consultarTipoTrabajador($usuario, $password){

        //Se requiere el archivo para la conexión.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        $datos = "SELECT tipoTrab from Trabajador where correoTrab = '" . $usuario . "' and contraTrab= md5('".$password."')";
        //Se ejecuta la sentencia sql
        $result = mysqli_query($conn, $datos);
        //Se muestran los datos encontrados de la busqueda

        while ($row = mysqli_fetch_row($result)){
            //Se asigna el tipo de trabajador que se encontro.
            $tipo = $row[0];
        }
        
        return $tipo;

        mysqli_close($conn);
    }

    function registrarVisitante($nombre, $apellidoMaterno, $apellidoPaterno, $correo, $contrasena){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Visitante (nombVisit,apellPatVisit,apellMatVisit,correoVisit,contraVisit) values ('".$nombre."','".$apellidoPaterno."','".$apellidoMaterno."','".$correo."',md5('".$contrasena."'))";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    function sesion($usuario, $tipoUsuario){

        //Se requiere el archivo para la conexión.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        if($tipoUsuario === "Visitante"){
            $sql = "select idVisitante from Visitante where correoVisit = '" . $usuario . "'";

        }else{
            $sql = "Select idTrabajador from Trabajador where correoTrab = '" . $usuario . "'";
        }

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            //se dirige a menu correspondiente.
            $_SESSION['usuario'] = $row['0'];
            $idUsuario =  $row['0'];
        }

        return $idUsuario;

        mysqli_close($conn);
    }

    function obtenerDatos($campo,$campoBuscar, $tipoUsuario){
        
        //Se requiere el archivo para la conexión.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
       
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
        
        return $datos;
        
        mysqli_close($conn);
    }

    function actualizarContrasena($id,$contrasena,$tipoUsuario){
        
        //Se requiere el archivo para la conexión.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        if($tipoUsuario === "Visitante"){
            $query="UPDATE Visitante SET  contraVisit =  md5('".$contrasena."') where idVisitante = ".$id;
        }else{
            $query="UPDATE Trabajador SET  contraTrab = md5('".$contrasena."') where idTrabajador = ".$id;
        }
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);
    }



?>
