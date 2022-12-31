<?php
    function buscadorLocales($buscador,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "SELECT idTienda, nombTienda from Tienda where idTrabajador=".$id;

        }else{

            $sql = "SELECT idTienda, nombTienda from Tienda inner join Trabajador on Trabajador.idTrabajador =  Tienda.idTrabajador
            where (nombTienda like '%".$buscador."%') and  Tienda.idTrabajador=".$id;
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function verLocalesHome(){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        $sql = "SELECT * from Tienda";
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function consultarLocalXNombre($nombreNegocio){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Se realiza un conteo de cuantos locales tienen la misma clave.
        $sql  = "SELECT count(*) as contar from TIenda where nombTienda = '".$nombreNegocio."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function existeLocalIgual($idNegocio,$nombreNegocio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un conteo de cuantos  tienen la misma clave.
        $sql  = "Select count(*) as contar from Tienda where nombTienda = '".$nombreNegocio."' and idTienda <> '".$idNegocio."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }
    function agregarLocal($nombreNegocio, $id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Tienda (idTienda,nombTienda,idTrabajador) values (0,'".$nombreNegocio."','".$id."')";
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    function editarLocal($nombreNegocio,$idNegocio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Tienda SET  nombTienda = '".$nombreNegocio."' WHERE idTienda='".$idNegocio."'";
        
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    function eliminarLocal($idNegocio){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $queryProductos = "DELETE FROM Producto WHERE idTienda='".$idNegocio."'";
        $queryNegocio="DELETE FROM Tienda WHERE idTienda='".$idNegocio."'";
    
        //Se realiza un query 
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito en la pagina.
        if($conn->query($queryProductos) === TRUE){
            if($conn->query($queryNegocio) === TRUE){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }
?>