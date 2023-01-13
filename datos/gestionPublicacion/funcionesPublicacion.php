<?php

    /*
        Nombre de la función: consultarPublicacion
        Entrada: Nombre del servicio
        Salida: Resultado de los datos obtenidos

        Descripción: Esta función se encarga de consultar las publicaciones por el nombre de un servicio.
    */
    function consultarPublicaciones($servicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query con el que se consultan datos de las publicaciones y de los servicios
        $sql = "SELECT idPublicacion, titulo, descripcion, tipoPublicacion, archivo, nombServ from Publicacion 
        inner join Servicio on Servicio.idServicio = Publicacion.idServicio where nombServ = '".$servicio."'";
           
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retorna el resultado de la consulta

        mysqli_close($conn);//Se cierra la conexión

    }

    /*
        Nombre de la función: buscadorPublicacion
        Entrada: Buscador(Frase o palabra)
        Salida: Regisitros obtenidos de la consulta

        Descripción: Esta publicación permite realizar búsquedas en la base de datos
        con una frase o palabra que el usuario envie.
    */
    function buscadorPublicaciones($buscador){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que el buscador este vacio, se crea un sql para mostrar los datos de las publicaciones almacenadas en la base de datos. 
            $sql = "SELECT idPublicacion, titulo, descripcion, tipoPublicacion, archivo, nombServ from Publicacion 
            inner join Servicio on Servicio.idServicio = Publicacion.idServicio order by idPublicacion desc";
        
        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla publicacion
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            
            $sql = "SELECT idPublicacion, titulo, descripcion, tipoPublicacion, archivo, nombServ from Publicacion 
            inner join Servicio on Servicio.idServicio = Publicacion.idServicio where titulo like '%".$buscador."%' 
            or descripcion like '%".$buscador."%' or tipoPublicacion like '%".$buscador."%' or archivo like 
            '%".$buscador."%'  or nombServ like '%".$buscador."%' order by idPublicacion desc";
        }
              
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retornan los datos obtenidos de la consulta

        mysqli_close($conn);//Se cierra la conexión
    }

    /*
        Nombre de la función: servicios
        Entrada: ninguna
        Salida: Servicios

        Descripción: Esta función realiza una consulta de los servicios almacenados en la base de datos.
    */
    function servicios(){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para recuperar datos de los servicios almacenados en la base de datos
        $query="SELECT * FROM Servicio";

        //Se ejecuta la sentencia sql
        $resultado=mysqli_query($conn,$query);

        return $resultado; //Se retornan los datos de los servicios obtenidos

        mysqli_close($conn); //Se cierra la conexión con la bd.
    }


    /*  
        Nombre de la función: agregarPublicacion
        Entrada: tipo de publicacion, ruta del archivo, titulo, descripción y id del servicio
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de una nueva tarifa con los datos enviados de la capa lógica.
    */
    function agregarPublicacion($tipoPublicacion,$ruta,$titulo,$descripcion,$servicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para realizar la inserción de una publicación
        $query  = "INSERT INTO Publicacion (idPublicacion, tipoPublicacion, archivo, titulo, descripcion, idServicio) VALUES (0,'".$tipoPublicacion."','".$ruta."','".$titulo."','".$descripcion."','".$servicio."')";
       
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn); //Se cierra la conexión con la bd.
    }

    /*
        Nombre de la función: rutaImagen
        Entrada: id de la publicacion
        Salida: ruta de la imagen

        Descripción: Esta función permite obtener la ruta de la imagen almacenda, solo basta contar con el 
        id de la publicación.
    */
    function rutaImagen($idPublicacion){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se ejecuta el query que obtiene la ruta de la publicación
        $buscarPub = mysqli_query($conn,"SELECT archivo FROM Publicacion WHERE idPublicacion ='".$idPublicacion."'");

        //Se almacenan los datos en un array
        $resultado = mysqli_fetch_array($buscarPub);

        return $resultado; //Se retorna el resultado
         
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }

    /*  
        Nombre de la función: editarPublicacion
        Entrada: bandera, tipo de publicación, ruta del video o de la imagen, titulo, descripción, id del servicio y id de la publicación
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la publicación con los datos enviados.
    */
    function editarPublicacion($bandera,$tipoPublicacion,$ruta,$titulo,$descripcion,$servicio,$idPublicacion){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //De acuerdo a la bandera este se seleccionará el query correspondiente.  La bandera es para ssaber si se debe o no actualizar la ruta de la imagen o video
        if($bandera === 1){
            $query="UPDATE Publicacion SET  tipoPublicacion = '".$tipoPublicacion."', archivo = '".$ruta."', titulo = '".$titulo."', descripcion = '".$descripcion."', idServicio = '".$servicio."' WHERE idPublicacion='".$idPublicacion."'";
        }else{
            $query="UPDATE Publicacion SET  tipoPublicacion = '".$tipoPublicacion."', titulo = '".$titulo."', descripcion = '".$descripcion."', idServicio = '".$servicio."' WHERE idPublicacion='".$idPublicacion."'";
        }

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn); //Se cierra la conexión con la bd.
    }

    /*  
        Nombre de la función: eliminarPublicación
        Entrada: Id de la publicación
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de una publicación indicada por el usuario.
    */
    function eliminarPublicacion($idPublicacion){
        //Se utiliza require en caso de error para detener el script. El archivo contiene la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la eliminación de la publicación con el id de la publicación
        $query="DELETE FROM Publicacion WHERE idPublicacion='".$idPublicacion."'";

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        
        mysqli_close($conn); //Se cierra la conexión con la bd.

    }
?>