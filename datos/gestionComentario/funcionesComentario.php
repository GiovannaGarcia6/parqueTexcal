<?php
    function buscadorComentarios($buscador,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que no exista la variable buscador, se crea un sql para mostrar los datos de los
            //empleados almacenados en la base de datos. 
            $sql = "select idComentario, contenido, puntuacion, nombServ from Comentario inner join Servicio on Comentario.idServicio =  Servicio.idServicio
            where idVisitante=".$id;
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla empleados
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla Empleados se obtienen los campos de id, tipo de trabajador, nombre, apellidos y correo.
            
            $sql = "Select idComentario, contenido, puntuacion, nombServ from Comentario inner join Servicio on Comentario.idServicio =  Servicio.idServicio
            where idVisitante='".$id."' and (contenido like '%".$buscador."%' or puntuacion like '%".$buscador."%' or nombServ like '%".$buscador."%')";
            
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }

    function buscadorComentariosAdmin($buscador){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que no exista la variable buscador, se crea un sql para mostrar los datos de los
            //empleados almacenados en la base de datos. 
            $sql = "SELECT idComentario, contenido, puntuacion, nombServ, nombVisit, apellPatVisit from
            Visitante inner join Comentario on Visitante.idVisitante = Comentario.idVisitante inner join Servicio on Comentario.idServicio =  Servicio.idServicio";
                        
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla empleados
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla Empleados se obtienen los campos de id, tipo de trabajador, nombre, apellidos y correo.
            
            $sql = "SELECT idComentario, contenido, puntuacion, nombServ, nombVisit, apellPatVisit from
            Visitante inner join Comentario on Visitante.idVisitante = Comentario.idVisitante inner join 
            Servicio on Comentario.idServicio =  Servicio.idServicio where contenido like '%".$buscador."%' or puntuacion like '%".$buscador."%' or nombreServ like '%".$buscador."%'";
            
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }

    function buscadorComentariosXServicio($servicio){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql = "SELECT contenido, puntuacion, nombVisit, apellPatVisit from
        Visitante inner join Comentario on Visitante.idVisitante = Comentario.idVisitante where idServicio=".$servicio;
                        
    
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }

    function agregarComentario($comentario, $puntuacion, $idUsuario, $servicio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
       
        $query  = "Insert into Comentario (idComentario, Contenido, Puntuacion, idVisitante, idServicio) values (0,'".$comentario."','".$puntuacion."','".$idUsuario."','".$servicio."')";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
       
        mysqli_close($conn);//Se cierra la conexión

    }


    function editarComentario($idComentario,$comentario, $puntuacion, $idUsuario, $servicio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        $query="UPDATE Comentario SET  Contenido = '".$comentario."', Puntuacion = '".$puntuacion."', idServicio = '".$servicio."' WHERE idComentario='".$idComentario."'";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
       
        mysqli_close($conn);//Se cierra la conexión

    }


    function eliminarComentario($idComentario){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    
        $query="DELETE FROM Comentario WHERE idComentario='".$idComentario."'";

        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
       
        mysqli_close($conn);//Se cierra la conexión

    }
?>