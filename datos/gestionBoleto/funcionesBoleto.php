<?php
    /*  
        Nombre de la función: buscadorBoleto
        Entrada: Buscador(palabra o frase)
        Salida: Resultado que contiene los registros de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */

    function buscadorBoleto($buscador){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso de que buscador este vacío se crea un sql para mostrar los datos de las tarifas almacenados en la base de datos. 
            $sql = "select idTarifa, nombTar, precioTar, nombServ from Tarifa 
            inner join Servicio on Tarifa.idServicio =  Servicio.idServicio";

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla tarifa y de servicio
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla  se obtienen los campos de id, nombre y precio de la tarifa.
            //De la tabla servicio se obtiene el nombre del servicio.
            $sql = "select idTarifa, nombTar, precioTar, nombServ from Tarifa 
            inner join Servicio on Tarifa.idServicio =  Servicio.idServicio
            where nombTar like '%".$buscador."%' or precioTar like '%".$buscador."%' or nombServ like '%".$buscador."%'";
                        
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retornan los registros 

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: boletosServicios
        Entrada: Id del servicio
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos para obtener el nombre y precio de la tarifa.
    */
    function boletosServicios($idServicio){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para obtener el nombre y precio de la tarifa
        $sql = "SELECT nombTar, precioTar from Tarifa where idServicio =".$idServicio;
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el ressultado obtenido

        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: consultarBoletosXNombre
        Entrada: Nombre de la tarifa
        Salida: Resultado con el conteo de los registros

        Descripción: La función realiza una consulta a la base de datos para contabilizar los registros que cumplan con la condición.
    */
    function consultarBoletosXNombre($nombre){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para contabilizar los registros que tengan el nombre que indico el usuario
        $sql  = "SELECT count(*) as contar from tarifa where nombTar = '".$nombre."'";

        //Se realiza la ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado de la ejecución
        $resultado = mysqli_fetch_array($consulta);

        return  $resultado['contar']; //Se retorna el número de registros que coinciden con el nombre de la tarifa

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: consultarBoletoXServicio
        Entrada: Id del servicio, nombre de la tarifa y id de la tarifa
        Salida: Resultado con el conteo de los registros

        Descripción: La función realiza una consulta a la base de datos para contabilizar los registros que cumplan
        con la condición.
    */
    function consultarBoletoXServicio($servicio, $nombre, $idTarifa){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos registros cumplen con la condición.
        $sql  = "Select count(*) as contar from Tarifa where idServicio = '".$servicio."' and nombTar = '".$nombre."' and idTarifa <> '".$idTarifa."'";
        
        //Se realiza la ejecución del query
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado de la ejecución
        $resultado = mysqli_fetch_array($consulta);

        return  $resultado['contar'];//Se retorna el número de registros que coinciden

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: agregarBoleto
        Entrada: Precio de la tarifa, nombre de la tarifa y id del servicio
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de una nueva tarifa con los datos enviados de la capa lógica.
    */
    function agregarBoleto($precio,$nombre,$servicio){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "insert into Tarifa (idTarifa,precioTar,nombTar,idServicio) values (0,'".$precio."','".$nombre."','".$servicio."')";

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: editarBoleto
        Entrada: Precio, nombre de la tarifa, id del servicio y id de la tarifa
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización con los datos enviados por el usuario.
    */
    function editarBoleto($precio, $nombre, $servicio, $idTarifa){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Tarifa SET  precioTar = '".$precio."', nombTar = '".$nombre."', idServicio = '".$servicio."' WHERE idTarifa='".$idTarifa."'";
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: eliminarBoleto
        Entrada: Id de la tarifa
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de una tarifa indicada por el usuario.
    */
    function eliminarBoleto($idTarifa){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para eliminar la tarifa con el id de la tarifa
        $query="DELETE FROM Tarifa WHERE idTarifa='".$idTarifa."'";

       //Se ejecuta el query
       if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        mysqli_close($conn);//Se cierra la conexión
    }
    
?>

