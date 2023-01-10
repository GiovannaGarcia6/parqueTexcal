<?php
    /*  
        Nombre de la función: consultarTrabajadores
        Entrada: Sin parametros
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos con el cual se obtienen los datos de
        los trabajadores que sean tipo guia.
    */
    function consultarTrabajadores(){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query con el cual se realizara la consulta de todos los trabajadores que sean guias.
        $consulta="SELECT * from trabajador where tipoTrab='Guia'";

        //Se realiza la ejecución del query
        $ejecutar=mysqli_query($conn,$consulta);

        return $ejecutar; //Se retorna el resultado obtenido de la ejecución
        
        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: obtenerIdTrabajadorXCorreo
        Entrada: Correo electrónico del usuario
        Salida: id del trabajador

        Descripción: La función realiza una consulta a la base de datos para obtener el id del trabajador
        de acuerdo a su correo.
    */
    function obtenerIdTrabajadorXCorreo($correo){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para obtener el id del trabajador
        $query = "SELECT idTrabajador from Trabajador where correoTrab = '".$correo."'";  

        //Se realiza la ejecución del query
        $resultado = mysqli_query($conn, $query);

        //El resultado se almacena en un array
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['idTrabajador']; //Se retorna el dato obtenido de la ejecución

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: visitasEnEspera
        Entrada: Id del visitante
        Salida: Retorna el número de visitas

        Descripción: La función realiza una consulta a la base de datos para contabilizar las visitas guiadas
        en espera que tenga el visitabte
    */
    function visitasEnEspera($idVisitante){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para contar cuantas visitas en espera tiene el visitante
        $query  = "SELECT count(*) as contar from visitaGuiada where idVisitante = '".$idVisitante."' and estadoVisi = 'En espera'";
        
        //Se realiza la ejecución del query
        $resultado = mysqli_query($conn, $query);

        //El resultado se almacena en un array
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['contar']; //Se retorna el dato obtenido de la ejecución

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: agregarVisita
        Entrada: Fecha de la visita, id del visitante y id del trabajador
        Salida: Retorna el un numeró (0 - 1) de acuerdo al resultado de la ejecución

        Descripción: La función realiza la inserción de una nueva visita guiada, en la que al ejecutarse el query se verfica si ha
        sido exitosa o errónea.
    */
    function agregarVisita($fecha, $idVisitante, $idTrab){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into visitaGuiada(idVisitaGuiada,fechVisi,estadoVisi,idVisitante,idTrabajador) values (null,adddate(FROM_UNIXTIME('".$fecha."'),interval 1 day),'En espera',".$idVisitante.",".$idTrab.")"; 
        
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: buscadorVisitas
        Entrada: Palabra o frase a buscar, el id del visitante y el estado de la visita.
        Salida: Datos de la visita(id de la visita, fecha de la visita, estado de la visita y correo del trabajador).

        Descripción: La función realiza una consulta a la base de datos para contabilizar las visitas guiadas
        en espera que tenga el visitante.
    */
    function buscadorVisitas($buscador,$id,$estadoVisita){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Si el buscador esta vacío, se debe de crear un query para obtener todas las visitas de acuerdo al estado y al id del visitante
        if($buscador === ""){

            $sql = "Select idVisitaGuiada,fechVisi,estadoVisi, correoTrab from visitaGuiada INNER JOIN Trabajador on Trabajador.idTrabajador=visitaGuiada.idTrabajador
            where idVisitante= ".$id." and estadoVisi='".$estadoVisita."'";

        }else{

            //En otro caso, se realiza el query utilizando like para obtener todos los posibles coincidencias 
            $sql = "Select idVisitaGuiada,fechVisi, estadoVisi, correoTrab from visitaGuiada INNER JOIN Trabajador on Trabajador.idTrabajador=visitaGuiada.idTrabajador
            where fechVisi like '%".$buscador."%' or correoTrab like '%".$buscador."%' and idVisitante= ".$id." and estadoVisi='".$estadoVisita."'";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retorna el resultado con los datos obtenidos de la consulta

        mysqli_close($conn); //Se cierra la conexión
    
    }

    /*  
        Nombre de la función: buscadorVisitasGuia
        Entrada: Palabra o frase a buscar, el id del trabajador y el estado de la visita.
        Salida: Datos de la visita(id de la visita, fecha de la visita, estado de la visita y correo del trabajador).

        Descripción: La función realiza una consulta a la base de datos para contabilizar las visitas guiadas
        en espera que tenga el trabajador.
    */
    function buscadorVisitasGuia($buscador,$id,$estadoVisita){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Si el buscador esta vació, se debe de crear un query para obtener todas las visitas de acuerdo al estado y al id del trabajador

        if($buscador === ""){

            $sql = "Select idVisitaGuiada, fechVisi, correoVisit from visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante
            where idTrabajador= ".$id." and estadoVisi='".$estadoVisita."'";

        }else{

            //En otro caso, se realiza el query utilizando like para obtener todos los posibles coincidencias 
            $sql = "Select idVisitaGuiada, fechVisi, correoVisit from visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante
            where fechVisi like '%".$buscador."%' or correoVisit like '%".$buscador."%' and idTrabajador= ".$id." and estadoVisi='".$estadoVisita."'";
        
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retorna el resultado con los datos obtnenidos de la consulta

        mysqli_close($conn);//Se cierra la conexión
    
    }

    /*  
        Nombre de la función: cancelarVisita
        Entrada: Id de la visita guiada.
        Salida: Retorna un 1 o un 0 dependiendo del resultado de la ejecuón.

        Descripción: La función realiza la cancelación de una visita guiada, esto incluye realizar la eliminación
        de los mensajes del chat, el chat y la visita guiada.
    */
    function cancelarVisita($idVisita){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Se obtiene el id del chat con el id de la visita
        $idChat = obtenerIdChat($idVisita);
        
        //Query para eliminar los mensajes que tenga el chat
        $query1 = "DELETE FROM mensaje WHERE idChat =".$idChat; 

        //Query para eliminar el registro del chat
        $query2 = "DELETE FROM chat WHERE idVisitaGuiada=".$idVisita; 

        //Query para eliminar el registro de la visita guiada
        $query3 = "DELETE FROM visitaGuiada WHERE idVisitaGuiada=".$idVisita;
        
        //Se realiza la ejecución de los querys
        if(($conn->query($query1) === TRUE) && ($conn->query($query2) === TRUE) && ($conn->query($query3) === TRUE)){  
            return 1; //Se retorna 1, si la ejecución de los querys fue exitosa
        }else{
            return 0; //Se retorna 0, si alguna de las ejecuciones fue erronea
        }


        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: obtenerCorreoVisitante
        Entrada: Id de la visita guiada.
        Salida: Correo del visitante

        Descripción: La función permite obtener el correo del visitante al cual se le va a ralizar la visita guiada.
    */
    function obtenerCorreoVisitante($idVisita){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
     
        //Query para obtener el correo del visitante
        $query = "SELECT correoVisit from visitaGuiada INNER JOIN visitante on visitante.idVisitante=visitaGuiada.idVisitante  WHERE idVisitaGuiada =".$idVisita;
        
        //Se realiza la ejecución del query
        $resultado = mysqli_query($conn, $query);

        //Se almacena el correo en la variable datos
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['correoVisit']; //Se retorna el correo

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: aceptarVisita
        Entrada: Id de la visita guiada.
        Salida: Retorna un 1 o un 0 dependiendo del resultado de la ejecuón.

        Descripción: La función realiza la cancelación de una visita guiada, esto incluye realizar la eliminación
        de los mensajes del chat, el chat y la visita guiada.
    */
    function aceptarVisita($idVisita){

        //Archivo que permite realizar la conexión con la base de datos        
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        //Qeury para actualizar el estado de la visita guiada
        $query = "UPDATE visitaGuiada SET estadoVisi='Pendiente' WHERE idVisitaGuiada='".$idVisita."'";

        //Query para realizar la inserción de un nuevo chat 
        $query2 = "INSERT INTO chat(idChat,idVisitaGuiada) values (null,".$idVisita.")"; 

        //Se realiza la ejecución de los querys
        if(($conn->query($query) === TRUE) && ($conn->query($query2) === TRUE)){  
            return 1; //Se retorna 1, si la ejecución de los querys fue exitosa
        }else{
            return 0; //Se retorna 0, si alguna de las ejecuciones fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: finalizarVisita
        Entrada: Id de la visita guiada.
        Salida: Retorna un 1 o un 0 dependiendo del resultado de la ejecuón.

        Descripción: La función realiza la finalización de una visita guiada, esto incluye realizar la actalización
        de la visita guiada, la eliminación chat con sus mensajes.
    */
    function finalizarVisita($idVisita){

        //Archivo que permite realizar la conexión con la base de datos        
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se obtiene el id del chat con el id de la visita
        $idChat = obtenerIdChat($idVisita);

        //Qeury para actualizar el estado de la visita guiada
        $query1 = "UPDATE visitaGuiada SET estadoVisi='Finalizada' WHERE idVisitaGuiada='".$idVisita."'";

        //Query para eliminar los mensajes del chat
        $query2 = "DELETE FROM mensaje WHERE idChat =".$idChat; 

        //Query para eliminar el chat
        $query3 = "DELETE FROM chat WHERE idVisitaGuiada=".$idVisita; 

        if(($conn->query($query1) === TRUE) && ($conn->query($query2) === TRUE) && ($conn->query($query3) === TRUE)){  
            return 1; //Se retorna 1, si la ejecución de los querys fue exitosa
        }else{
            return 0; //Se retorna 0, si alguna de las ejecuciones fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: obtenerIdChat
        Entrada: Id de la visita guiada.
        Salida: Retorna el id del chat.

        Descripción: La función realiza unaconsulta para obtener el id del chat con el id de la visita guiada.
    */
    function obtenerIdChat($idVisita){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para obtener el id del chat con el id de la visita
        $query = "SELECT idChat from chat where idVisitaGuiada = '".$idVisita."'";  

        //Se realiza la ejecución del query
        $resultado = mysqli_query($conn, $query);

        //Se almacena el correo en la variable datos
        $datos = mysqli_fetch_assoc($resultado);

        return $datos['idChat']; //Se retorna el id del chat

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: rechazarVisita
        Entrada: Id de la visita guiada.
        Salida: Retorna un 1 o un 0 dependiendo del resultado de la ejecuón.

        Descripción: La función realiza la cancelación de una visita guiada, esto incluye realizar la eliminación
        de los mensajes del chat, el chat y la visita guiada.
    */
    function rechazarVisita($idVisita){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Query para eliminar la visita guiada que sea igual al id de la visita
        $query = "DELETE FROM visitaGuiada WHERE idVisitaGuiada=".$idVisita;
        
        //Se realiza la ejecución del query
        if(($conn->query($query) === TRUE)){  
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión

    }
?>