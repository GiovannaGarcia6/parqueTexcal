<?php

    /*  
        Nombre de la función: nombreUsuarioChat
        Entrada: Id de la visita y el tipo de usuario
        Salida: Nombre del usuario

        Descripción: La función realiza una consulta a la base de datos con el cual se obtienen el nombre del visitante 
        o del trabajador, dependiendo de los datos que se hayan obtenido de la capa lógica.  
    */
    function nombreUsuarioChat($idVisita,$tipoUsuario){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Si el tipo de usuario es visitante se realiza el query pertinente para obtener el nombre del visitante.
        if($tipoUsuario === "Visitante"){

            //Query con el que se va a obtener el nombre del visitante realizando una unión de tablas.
            $query = "SELECT nombVisit FROM visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante where idVisitaGuiada = '".$idVisita."'";  
            
            //La variable resultado almacenara lo que se obtenga al realizar la ejecución del query
            $resultado = mysqli_query($conn, $query);

            //En la varible datos se almacena un array con el resultado que se obtuvo
            $datos = mysqli_fetch_assoc($resultado);

            //Se retorna la varible
            return $datos['nombVisit'];
        }else{

            //Query con el que se va a obtener el nombre del guía realizando una unión de tablas.
            $query = "SELECT nombreTrab FROM visitaGuiada INNER JOIN trabajador on trabajador.idTrabajador=visitaGuiada.idTrabajador where idVisitaGuiada = '".$idVisita."'";  
            
            //La variable resultado almacenará lo que se obtenga al realizar la ejecución del query
            $resultado = mysqli_query($conn, $query);
            
            //En la varible datos se almacena un array con el resultado que se obtuvo
            $datos = mysqli_fetch_assoc($resultado);

            //Se retorna la varible
            return $datos['nombreTrab'];
        }
       
        
        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: idChat
        Entrada: Id de la visita 
        Salida: Id del chat

        Descripción: La función realiza una consulta a la base de datos con el cual se obtienen el id del chat.
    */

    function idChat($idVisita){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que permite hacer una consulta para obtener el id del chat de acuerdo con el id de la visita guiada
        $query = "SELECT idChat FROM chat where idVisitaGuiada = '".$idVisita."'";  
        
        //La variable resultado almacenará lo que se obtenga al realizar la ejecución del query
        $resultado = mysqli_query($conn, $query);

        //En la varible datos se almacena un array con el resultado que se obtuvo
        $datos = mysqli_fetch_assoc($resultado);

        //Se retorna la varible
        return $datos['idChat'];
        
        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: enviarMensaje
        Entrada: Id de la visita, tipo de usuario y el mensaje 
        Salida: Retorna un 1 o un 0 dependiendo del resultado.

        Descripción: La función realiza una inserción de un nuevo mensaje a la tabla mensaje.
    */
    function enviarMensaje($idVisita,$tipoUsuario,$msg){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se obtiene el nombre del usuario con ayuda de la funcion nombreUsuarioChat en el que se deben
        //de mandar datos del id de la visita y el tipo de usuario al cual se le va a obtener el nombre
        $nombre = nombreUsuarioChat($idVisita,$tipoUsuario);

        //Se obtiene el id del chat con la funciín idChat en el que se le manda el id de la visita
        $idChat = idChat($idVisita);

        //Query para la inserción del nuevo mensaje
        $query  = "Insert into mensaje(idMensaje,nombre,mensaje,idChat) values (null,'".$nombre."','".$msg."',".$idChat.")"; 
        
        //Se ejecutala sentencia sql
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    
    /*  
        Nombre de la función: usuarioDestino
        Entrada: Id de la visita y tipo de usuario.
        Salida: Retorna la variable resultado con los datos de la consulta realizada.
        
        Descripción: La función realiza una consulta a las tablas dependiendo del tipo de usario y asi obtener el nombre 
        y apellido del usuario destino.
    */
    function usuarioDestino($idVisita,$tipoUsuario){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        /*Si el tipo de usuario es un visitante se realiza el query que permitirá realizar la consulta para 
        obtener el nombre y apellido del visitante. En caso de que el tipo de usuario sea diferente a visitante, 
        se crea el query para obtener el nombre y apellido del trabajador*/
        if($tipoUsuario === "Visitante"){
            $query = "SELECT nombVisit, apellPatVisit FROM visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante where idVisitaGuiada = '".$idVisita."'";  
        }else{
            $query = "SELECT nombreTrab, apellPatTrab FROM visitaGuiada INNER JOIN trabajador on trabajador.idTrabajador=visitaGuiada.idTrabajador where idVisitaGuiada = '".$idVisita."'";  
        }

        //La variable resultado almacenará lo que se obtenga al realizar la ejecución del query
        $resultado = mysqli_query($conn, $query);

        return  $resultado; //Se retorna el resultado obtenido de la ejecución del query
        
        mysqli_close($conn);//Se cierra la conexión

    }


    function consultarMensajes($idVisita){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //El siguiente query realiza una consulta de todos los mensajes del chat de la visita
        $query = "SELECT * FROM mensaje INNER JOIN chat on chat.idChat=mensaje.idChat WHERE idVisitaGuiada='".$idVisita."'";

        //La variable resultado almacenará lo que se obtenga al realizar la ejecución del query
        $resultado = mysqli_query($conn, $query);

        return  $resultado; //Se retorna el resultado obtenido de la ejecución del query
        
        mysqli_close($conn);//Se cierra la conexión
    }
?>