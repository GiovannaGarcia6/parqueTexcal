<?php
    function buscadorProductos($buscador,$idTienda){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){

            $sql = "SELECT idProducto, nombreProd, precioProd, descProd, imagenProd from Producto  where idTienda=".$idTienda;

        }else{

            $sql = "SELECT idProducto, nombreProd, precioProd, descProd, imagenProd from Producto
            where (idProducto like '%".$buscador."%' or nombreProd like '%".$buscador."%' or precioProd like '%".$buscador."%' or descProd like '%".$buscador."%') and idTienda=$idTienda";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado;

        mysqli_close($conn);//Se cierra la conexión
    
    }

    function consultarProductoXNombre($nombreProducto, $idTienda){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Producto where nombreProd = '".$nombreProducto."' and idTienda = '".$idTienda."' ";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión

    }

    function consultarProductoID($nombreProducto, $idTienda){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Producto where nombreProd = '".$nombreProducto."' and idTienda <> '".$idTienda."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function buscarProductoXId($idProd){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Producto where idProducto = '".$idProd."'";
        $consulta =  mysqli_query($conn, $sql);
        $array = mysqli_fetch_array($consulta);

        return $array['contar'];

        mysqli_close($conn);//Se cierra la conexión
    }

    function obtenerIdTienda($idProd){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se crea un query para mostrar datos del boleto seleccionado para modificar.
        $buscar=mysqli_query($conn,"SELECT idTienda from Producto WHERE idProducto ='".$idProd."'");
        $filas=mysqli_fetch_array($buscar);
        //Se obtienen los datos del boleto.
        return $filas['idTienda'];

        mysqli_close($conn);//Se cierra la conexión

    }

    function agregarProducto($nombreProducto, $precioProducto, $descProducto, $archivo, $idTienda){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Producto (idProducto, nombreProd, precioProd, descProd,imagenProd,idTienda) values (0,'".$nombreProducto."','".$precioProducto."','".$descProducto."','".$archivo."','".$idTienda."')";
        
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }


    function editarProducto($bandera, $nombreProducto, $precioProducto, $descProducto, $archivo, $idProducto){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($bandera === 1){
            $query="UPDATE Producto SET  nombreProd = '".$nombreProducto."', precioProd = ".$precioProducto.", descProd= '".$descProducto."', imagenProd = '".$archivo."'   WHERE idProducto='".$idProducto."'";
        }else{
            $query="UPDATE Producto SET  nombreProd = '".$nombreProducto."', precioProd = ".$precioProducto.", descProd= '".$descProducto."'  WHERE idProducto='".$idProducto."'";
        }

        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn); //Se cierra la conexión con la bd.

    }

    function eliminarProducto($idProd){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = "DELETE FROM Producto WHERE idProducto='".$idProd."'";

        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn); //Se cierra la conexión con la bd.

    }
?>