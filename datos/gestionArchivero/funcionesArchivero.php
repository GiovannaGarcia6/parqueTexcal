<?php
    function buscadorCarpetas($buscador){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "SELECT idCarpeta, nombCarp FROM Carpeta";

        }else{
            $sql = "SELECT idCarpeta, nombCarp FROM Carpeta WHERE nombCarp like '%".$buscador."%'";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function contarCarpetasXNombre($nombreCarpeta){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Carpeta where nombCarp = '".$nombreCarpeta."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function contarCarpetasXNombreyid($nombreCarpeta,$idExpediente){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos  tiene la misma clave.
        $sql  = "SELECT count(*) as contar from Carpeta where nombCarp = '".$nombreExp."' and idCarpeta <> '".$idExpediente."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function agregarCarpeta($nombreCarpeta){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Carpeta (idCarpeta, nombCarp) values (0,'".$nombreCarpeta."')";
        
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    function editarCarpeta($nombreExp, $idExpediente){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Carpeta SET  nombCarp = '".$nombreExp."' WHERE idCarpeta='".$idExpediente."'";
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    function eliminarCarpeta($idCarpeta){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $queryArchivos = "DELETE FROM Archivo WHERE idCarpeta='".$idCarpeta."'";
        $queryExpediente="DELETE FROM Carpeta WHERE idCarpeta='".$idCarpeta."'";

        //Se realiza un query 
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina de taquilla.
        if(($conn->query($queryArchivos) === TRUE) && ($conn->query($queryExpediente) === TRUE)){
           return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    function buscadorArchivos($buscador,$idCarpeta){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "SELECT idArchivo, nombreArchivo, url FROM Archivo WHERE idCarpeta=$idCarpeta";

        }else{
            $sql = "SELECT idArchivo, nombreArchivo, url FROM Archivo WHERE nombreArchivo like '%".$buscador."%' and idCarpeta=$idCarpeta";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function nombreArchivo($string) {

        // Tranformamos todo a minusculas

        $string = strtolower($string);

        //Rememplazamos caracteres especiales latinos

        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

        $repl = array('a', 'e', 'i', 'o', 'u', 'n');

        $string = str_replace($find, $repl, $string);

        // Añadimos los guiones

        $find = array(' ', '&', '\r\n', '\n', '+');
        $string = str_replace($find, '-', $string);

        // Eliminamos y Reemplazamos otros carácteres especiales

        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');

        $repl = array('', '-', '');

        $string = preg_replace($find, $repl, $string);

        return $string;
    }

    function contarArchivosXNombre($nombreArchivo, $idCarpeta){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos administradores tiene la misma clave.
        $sql  = "Select count(*) as contar from Archivo where nombreArchivo = '".$nombreArchivo."' and idCarpeta = '".$idCarpeta."' ";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
        
        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function contarArchivosXID($idArchivo){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "Select count(*) as contar from Archivo where idArchivo = '".$idArchivo."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);
        
        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function agregarArchivo($nombreArchivo, $archivo, $idCarpeta){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Archivo (idArchivo, nombreArchivo, url, idCarpeta) values (0,'".$nombreArchivo."','".$archivo."','".$idCarpeta."')";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    function eliminarArchivo($idArchivo){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "DELETE FROM Archivo WHERE idArchivo='".$idArchivo."'";

        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    function obtenerDatosArchivo($idArchivo){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se crea un query para mostrar datos del boleto seleccionado para modificar.
        $buscar=mysqli_query($conn,"SELECT idCarpeta, url from Archivo WHERE idArchivo ='".$idArchivo."'");
        $datos=mysqli_fetch_array($buscar);

        return $datos;

        mysqli_close($conn);//Se cierra la conexión

    }
?>