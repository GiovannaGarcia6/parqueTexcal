<?php
    function buscadorBoleto($buscador){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que no exista la variable buscador, se crea un sql para mostrar los datos de los
            //empleados almacenados en la base de datos. 
            $sql = "select idTarifa, nombTar, precioTar, nombServ from Tarifa 
            inner join Servicio on Tarifa.idServicio =  Servicio.idServicio";

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla empleados
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla Empleados se obtienen los campos de id, tipo de trabajador, nombre, apellidos y correo.
            $sql = "select idTarifa, nombTar, precioTar, nombServ from Tarifa 
            inner join Servicio on Tarifa.idServicio =  Servicio.idServicio
            where nombTar like '%".$buscador."%' or precioTar like '%".$buscador."%' or nombServ like '%".$buscador."%'";
                        
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }


    function boletosServicios($idServicio){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

       
        $sql = "select nombTar, precioTar from Tarifa where idServicio =".$idServicio;
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }


    function consultarBoletosXNombre($nombre){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from tarifa where nombTar = '".$nombre."'";
        $consulta =  mysqli_query($conn, $sql);
        $resultado = mysqli_fetch_array($consulta);

        return  $resultado['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function consultarBoletoXServicio($servicio, $nombre, $idTarifa){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos  tiene la misma clave.
        $sql  = "Select count(*) as contar from Tarifa where idServicio = '".$servicio."' and nombTar = '".$nombre."' and idTarifa <> '".$idTarifa."'";
        $consulta =  mysqli_query($conn, $sql);
        $resultado = mysqli_fetch_array($consulta);

        return  $resultado['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    
    function agregarBoleto($precio,$nombre,$servicio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "insert into Tarifa (idTarifa,precioTar,nombTar,idServicio) values (0,'".$precio."','".$nombre."','".$servicio."')";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
           return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    function editarBoleto($precio, $nombre, $servicio, $idTarifa){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Tarifa SET  precioTar = '".$precio."', nombTar = '".$nombre."', idServicio = '".$servicio."' WHERE idTarifa='".$idTarifa."'";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina de taquilla.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
           return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    function eliminarBoleto($id,$idTarifa){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query="DELETE FROM Tarifa WHERE idTarifa='".$idTarifa."'";

        if($conn->query($query) === TRUE){
            return 1;
        }else{
           return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }
    
?>

