<?php

    /*  
        Nombre de la función: buscadorLocales 
        Entrada: Frase o palabra a buscar.
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */
    function buscadorLocales($buscador,$id){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //si el buscador esta vacío se crea un sql para mostrar los datos de los
            //locales almacenados en la base de datos. 
            $sql = "SELECT idTienda, nombTienda from Tienda where idTrabajador=".$id;

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla Tienda
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            $sql = "SELECT idTienda, nombTienda from Tienda inner join Trabajador on Trabajador.idTrabajador =  Tienda.idTrabajador
            where (nombTienda like '%".$buscador."%') and  Tienda.idTrabajador=".$id;
        }
            
        // Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado con los registros que coinciden con la búsqueda.

        mysqli_close($conn); //Se cierra la conexión
    
    }

    /*  
        Nombre de la función: verLocalesHome 
        Entrada: Sin parametros
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de todos los registros de la tabla tienda.
    */
    function verLocalesHome(){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para realizar una consulta de la tabla Tienda
        $sql = "SELECT * from Tienda";

        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retornan los registros

        mysqli_close($conn);//Se cierra la conexión
    
    }

    /*  
        Nombre de la función: consultarLocalXNombre 
        Entrada: Nombre del negocio
        Salida: Contador

        Descripción: La función realiza un conteo de todos los registros de la tabla tienda que 
        cumplan con el nombre que indico el usuario.
    */
    function consultarLocalXNombre($nombreNegocio){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Se realiza un conteo de cuantos locales tienen el mismo nombre.
        $sql  = "SELECT count(*) as contar from TIenda where nombTienda = '".$nombreNegocio."'";

        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado en un array
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el contador

        mysqli_close($conn); //Se cierra la conexión
    }

    /*  
        Nombre de la función: existeLocalIgual
        Entrada: Id y nombre del negocio
        Salida: Contador

        Descripción: La función realiza un conteo de todos los registros de la tabla tienda que 
        cumplan con que el nombre sea igual al que proporciono el usuario y que el id sea distinto.
    */
    function existeLocalIgual($idNegocio,$nombreNegocio){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos  tienen la misma clave.
        $sql  = "Select count(*) as contar from Tienda where nombTienda = '".$nombreNegocio."' and idTienda <> '".$idNegocio."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: agregarLocal
        Entrada: Nombre del negocio y id del trabajador.
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de un nuevo local con los datos enviados por el usuario.
    */
    function agregarLocal($nombreNegocio, $id){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Tienda (idTienda,nombTienda,idTrabajador) values (0,'".$nombreNegocio."','".$id."')";
        

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: editarLocal
        Entrada: Nombre del negocio y id del trabajador.
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la información del local con los datos enviados por el usuario.
    */
    function editarLocal($nombreNegocio,$idNegocio){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Tienda SET  nombTienda = '".$nombreNegocio."' WHERE idTienda='".$idNegocio."'";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: eliminarLocal
        Entrada: Id del negocio
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un negocio indicado por el usuario y si esta cuenta con productos también 
        son eliminados.
    */
    function eliminarLocal($idNegocio){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para eliminar todos los productos de la tienda
        $queryProductos = "DELETE FROM Producto WHERE idTienda='".$idNegocio."'";

        //Query para eliminar la tienda
        $queryNegocio="DELETE FROM Tienda WHERE idTienda='".$idNegocio."'";

        //Se ejecuta el query
        if(($conn->query($queryProductos) === TRUE) && ($conn->query($queryNegocio) === TRUE)){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }
?>