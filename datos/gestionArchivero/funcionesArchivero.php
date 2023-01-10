<?php
    /*  
        Nombre de la función: buscadorCarpetas
        Entrada: Frase o palabra a buscar
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos con el cual se obtienen los datos de las
        carpetas deacuerdo a lo que almacene el buscador.
    */
    function buscadorCarpetas($buscador){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Si el buscador esta vacío, se debe de crear un query para obtener el id y nombre de todas las carpetas
        if($buscador === ""){
            $sql = "SELECT idCarpeta, nombCarp FROM Carpeta";

        }else{
            //En otro caso, se realiza el query utilizando like para obtener todos los posibles coincidencias
            $sql = "SELECT idCarpeta, nombCarp FROM Carpeta WHERE nombCarp like '%".$buscador."%'";
        }
            
       //Se ejecuta la sentencia sql
       $resultado = mysqli_query($conn, $sql);

       return $resultado; //Se retorna el resultado con los datos obtenidos de la consulta

        mysqli_close($conn);//Se cierra la conexión
    
    }

    /*  
        Nombre de la función: contarCarpetasXNombre
        Entrada: Nombre de la carpeta
        Salida: Contador

        Descripción: La función realiza un conteo de las carpetas que sean igual al nombre que se ha proporcionado.
    */
    function contarCarpetasXNombre($nombreCarpeta){
        
        //Archivo que permite realizar la conexión con la base de datos        
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que cuenta las carpetas con el nombre especificado
        $sql  = "SELECT count(*) as contar from Carpeta where nombCarp = '".$nombreCarpeta."'";
        
        //Se realiza la ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión
    }
    /*  
        Nombre de la función: contarCarpetasXNombreyid
        Entrada: Nombre de la carpeta y id del carpeta
        Salida: Contador

        Descripción: La función realiza un conteo de las carpetas que sean igual al nombre que se ha proporcionado
        pero que no se encuentre en el id de la carpeta.
    */
    function contarCarpetasXNombreyid($nombreCarpeta,$idCarpeta){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos  tiene la misma clave.
        $sql  = "SELECT count(*) as contar from Carpeta where nombCarp = '".$nombreExp."' and idCarpeta <> '".$idCarpeta."'";
        
        //Se realiza la ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión
    }

    
    /*  
        Nombre de la función: agregarCarpeta
        Entrada: Nombre de la carpeta
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la inserción de una nueva carpeta.
    */
    function agregarCarpeta($nombreCarpeta){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Carpeta (idCarpeta, nombCarp) values (0,'".$nombreCarpeta."')";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: editarCarpeta
        Entrada: Nombre y id de la carpeta 
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la actualización del nombre de la carpeta.
    */
    function editarCarpeta($nombreCarpeta, $idCarpeta){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Carpeta SET  nombCarp = '".$nombreCarpeta."' WHERE idCarpeta='".$idCarpeta."'";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: eliminarCarpeta
        Entrada: Id de la carpeta
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de la carpeta por medio del id de la carpeta.
    */
    function eliminarCarpeta($idCarpeta){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para eliminar los archivos de la carpeta
        $queryArchivos = "DELETE FROM Archivo WHERE idCarpeta='".$idCarpeta."'";

        //Query para eliminar la carpeta
        $queryExpediente="DELETE FROM Carpeta WHERE idCarpeta='".$idCarpeta."'";

        //Se realiza la ejecución de los querys
        if(($conn->query($queryArchivos) === TRUE) && ($conn->query($queryExpediente) === TRUE)){
            return 1; //Se retorna 1, si la ejecución de los querys fue exitosa
        }else{
            return 0; //Se retorna 0, si alguna de las ejecuciones fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: buscadorArchivos
        Entrada: Buscador y id de la carpeta
        Salida: Se retorna el id, nombre y url del archivo

        Descripción: La función realiza una consulta a la tabla de archivo para obtener el id, nombre y url del archivo dependiendo
        de lo que tenga el buscador.
    */
    function buscadorArchivos($buscador,$idCarpeta){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Si el buscador esta vacío se obtiene el id, nombre y url de los archivos que pertenezcan al id de la carpeta indicada
        if($buscador === ""){
            $sql = "SELECT idArchivo, nombreArchivo, url FROM Archivo WHERE idCarpeta=$idCarpeta";
        }else{
            //Se realiza un query que permita obtener todas las posibles concidencias del buscador en los registros
            $sql = "SELECT idArchivo, nombreArchivo, url FROM Archivo WHERE nombreArchivo like '%".$buscador."%' and idCarpeta=$idCarpeta";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retorna el resultado 

        mysqli_close($conn);//Se cierra la conexión
    
    }

    /*  
        Nombre de la función: nombreArchivo
        Entrada: Nombre del archivo
        Salida: Se retorna el nuevo nombre del archivo

        Descripción: La función realiza la transformación del nombre del archivo para eliminar o reemplazar carácteres
        especiales.
    */
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

        return $string; //Se retorna el nombre del archivo
    }

    /*  
        Nombre de la función: contarArchivosXNombre
        Entrada: Nombre del archivo y id de la carpeta
        Salida: Se retorna el total de registros que cumplan con la condición

        Descripción: La función realiza un conteo de los archivos que tengan el mismo nombre y id de la carpeta que se indico.
    */
    function contarArchivosXNombre($nombreArchivo, $idCarpeta){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos archivos tienen el mismo nombre y id de la carpeta
        $sql  = "SELECT count(*) as contar from Archivo where nombreArchivo = '".$nombreArchivo."' and idCarpeta = '".$idCarpeta."' ";
       
        //Se realiza la ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: contarArchivosXNombre
        Entrada: Id del archivo
        Salida: Se retorna el total de registros que cumplan con la condición

        Descripción: La función realiza un conteo de los archivos que tengan el mismo id del archivo que se indico.
    */
    function contarArchivosXID($idArchivo){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Archivo where idArchivo = '".$idArchivo."'";
        
        //Se realiza la ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: agregarArchivo
        Entrada: Nombre del archivo, url del archivo y id de la carpeta
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la inserción de un nuevo archivo con los datos obtenidos de la capa lógica
    */
    function agregarArchivo($nombreArchivo, $archivo, $idCarpeta){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Archivo (idArchivo, nombreArchivo, url, idCarpeta) values (0,'".$nombreArchivo."','".$archivo."','".$idCarpeta."')";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: eliminarArchivo
        Entrada: Id del archivo
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un archivo que sea igual al id del archivo.
    */
    function eliminarArchivo($idArchivo){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "DELETE FROM Archivo WHERE idArchivo='".$idArchivo."'";

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: obtenerDatosArchivo
        Entrada: Id del archivo
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función obtiene los datos(id carpeta y url del archivo) que coincidan con el id del archivo que se indico.
    */
    function obtenerDatosArchivo($idArchivo){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se crea un query para obtener el id de la carpeta y url del archivo indicado
        $buscar=mysqli_query($conn,"SELECT idCarpeta, url from Archivo WHERE idArchivo ='".$idArchivo."'");
        
        $datos=mysqli_fetch_array($buscar); //Se almacenan los datos en un array

        return $datos; //Se retornan los datos

        mysqli_close($conn);//Se cierra la conexión

    }
?>