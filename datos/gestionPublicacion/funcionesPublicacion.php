<?php
    function consultarPublicaciones($servicio){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql = "Select idPublicacion, titulo, descripcion, tipoPublicacion, archivo, nombServ from Publicacion 
        inner join Servicio on Servicio.idServicio = Publicacion.idServicio where nombServ = '".$servicio."'";
           
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }


    function buscadorPublicaciones($buscador){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que no exista la variable buscador, se crea un sql para mostrar los datos de los
            //empleados almacenados en la base de datos. 
            $sql = "Select idPublicacion, titulo, descripcion, tipoPublicacion, archivo, nombServ from Publicacion 
            inner join Servicio on Servicio.idServicio = Publicacion.idServicio order by idPublicacion desc";
        
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla empleados
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla Empleados se obtienen los campos de id, tipo de trabajador, nombre, apellidos y correo.
            
            $sql = "Select idPublicacion, titulo, descripcion, tipoPublicacion, archivo, nombServ from Publicacion inner join Servicio on Servicio.idServicio = Publicacion.idServicio
            where titulo like '%".$buscador."%' or descripcion like '%".$buscador."%' or tipoPublicacion like '%".$buscador."%' or archivo like '%".$buscador."%'  or nombServ like '%".$buscador."%'
            order by idPublicacion desc";
        }
              
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión
       
    }

    function servicios(){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        $sentencia="SELECT * FROM Servicio";
        $resultado=mysqli_query($conn,$sentencia);
        return $resultado;
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }


    function agregarPublicacion($tipoPublicacion,$ruta,$titulo,$descripcion,$servicio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query  = "INSERT INTO Publicacion (idPublicacion, tipoPublicacion, archivo, titulo, descripcion, idServicio) VALUES (0,'".$tipoPublicacion."','".$ruta."','".$titulo."','".$descripcion."','".$servicio."')";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }

    function rutaImagen($idPublicacion){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $buscarPub=mysqli_query($conn,"SELECT archivo FROM Publicacion WHERE idPublicacion ='".$idPublicacion."'");
        $filas=mysqli_fetch_array($buscarPub);

        return $filas;
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }

    function editarPublicacion($bandera,$tipoPublicacion,$ruta,$titulo,$descripcion,$servicio,$idPublicacion){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($bandera === 1){
            $query="UPDATE Publicacion SET  tipoPublicacion = '".$tipoPublicacion."', archivo = '".$ruta."', titulo = '".$titulo."', descripcion = '".$descripcion."', idServicio = '".$servicio."' WHERE idPublicacion='".$idPublicacion."'";
        }else{
            $query="UPDATE Publicacion SET  tipoPublicacion = '".$tipoPublicacion."', titulo = '".$titulo."', descripcion = '".$descripcion."', idServicio = '".$servicio."' WHERE idPublicacion='".$idPublicacion."'";
        }

        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn); //Se cierra la conexión con la bd.

    }


    function eliminarPublicacion($idPublicacion){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query="DELETE FROM Publicacion WHERE idPublicacion='".$idPublicacion."'";
        //Se realiza un query 
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina de los comentarios.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
           return 0;
        }
        
        mysqli_close($conn); //Se cierra la conexión con la bd.

    }
?>