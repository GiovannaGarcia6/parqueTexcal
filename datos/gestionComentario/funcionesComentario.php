<?php
    /*  
        Nombre de la función: buscadorBoleto
        Entrada: Buscador y id del visitante
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */
    function buscadorComentarios($buscador,$id){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso de que el buscador este vacío , se crea un sql para mostrar los datos de los
            //comentarios almacenados en la base de datos. 
            $sql = "select idComentario, contenido, puntuacion, nombServ from Comentario inner join Servicio on Comentario.idServicio =  Servicio.idServicio
            where idVisitante=".$id;
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla comentario
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            $sql = "Select idComentario, contenido, puntuacion, nombServ from Comentario inner join Servicio on Comentario.idServicio =  Servicio.idServicio
            where idVisitante='".$id."' and (contenido like '%".$buscador."%' or puntuacion like '%".$buscador."%' or nombServ like '%".$buscador."%')";  
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado de los registros que cumplen

        mysqli_close($conn);//Se cierra la conexión

    }


    /*  
        Nombre de la función: buscadorBoleto
        Entrada: Buscador
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */
    function buscadorComentariosAdmin($buscador){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que no exista la variable buscador, se crea un sql para mostrar los datos de los
            //comentarios almacenados en la base de datos. 
            $sql = "SELECT idComentario, contenido, puntuacion, nombServ, nombVisit, apellPatVisit from
            Visitante inner join Comentario on Visitante.idVisitante = Comentario.idVisitante inner join Servicio on Comentario.idServicio =  Servicio.idServicio";
                        
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla comentario
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            $sql = "SELECT idComentario, contenido, puntuacion, nombServ, nombVisit, apellPatVisit from
            Visitante inner join Comentario on Visitante.idVisitante = Comentario.idVisitante inner join 
            Servicio on Comentario.idServicio =  Servicio.idServicio where contenido like '%".$buscador."%' or puntuacion like '%".$buscador."%' or nombreServ like '%".$buscador."%'";
            
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión

    }

    
    /*  
        Nombre de la función: buscadorComentariosXServicio
        Entrada: id del servicio
        Salida: Resultado con el conteo de los registros

        Descripción: La función realiza una consulta a la base de datos para obtener los datos de los comentarios por el id 
        del servicio.
    */
    function buscadorComentariosXServicio($servicio){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para obtener datos de los comentarios de un servicio
        $sql = "SELECT contenido, puntuacion, nombVisit, apellPatVisit from
        Visitante inner join Comentario on Visitante.idVisitante = Comentario.idVisitante where idServicio=".$servicio;
                        
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado

        mysqli_close($conn);//Se cierra la conexión

    }
    
    /*  
        Nombre de la función: agregarComentario
        Entrada: Comentario, puntuacion, id del usuario y id del servicio
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de un nuevo comenteario con los datos enviados de la capa lógica.
    */
    function agregarComentario($comentario, $puntuacion, $idUsuario, $servicio){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
       
        //Query para insertar un nuevo comentario
        $query  = "Insert into Comentario (idComentario, Contenido, Puntuacion, idVisitante, idServicio) values (0,'".$comentario."','".$puntuacion."','".$idUsuario."','".$servicio."')";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        
        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: editarComentario
        Entrada:id del comentario, comentario, puntuacion, id del usuario y id del servicio
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización del comentario con los datos enviados por el usuario.
    */
    function editarComentario($idComentario,$comentario, $puntuacion, $idUsuario, $servicio){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        //Query para actualizar el comentario
        $query="UPDATE Comentario SET  Contenido = '".$comentario."', Puntuacion = '".$puntuacion."', idServicio = '".$servicio."' WHERE idComentario='".$idComentario."'";

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
       
        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: eliminarComentario
        Entrada: Id del comentario
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un comentario indicado por el usuario.
    */
    function eliminarComentario($idComentario){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        //Query para eliminar un comentario
        $query="DELETE FROM Comentario WHERE idComentario='".$idComentario."'";

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
       
        mysqli_close($conn);//Se cierra la conexión

    }
?>