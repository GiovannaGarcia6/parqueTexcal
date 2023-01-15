<?php
    /*  
        Nombre de la función: buscadorProductos
        Entrada: Frase o palabra a buscar.
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */
    function buscadorProductos($buscador,$idTienda){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que el buscador este vacio, se crea un sql para mostrar los datos de las publicaciones almacenadas en la base de datos. 
            $sql = "SELECT idProducto, nombreProd, precioProd, descProd, imagenProd from Producto  where idTienda=".$idTienda;

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla producto
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            $sql = "SELECT idProducto, nombreProd, precioProd, descProd, imagenProd from Producto
            where (idProducto like '%".$buscador."%' or nombreProd like '%".$buscador."%' or precioProd like '%".$buscador."%' or descProd like '%".$buscador."%') and idTienda=$idTienda";
        }
            
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return $resultado; //Se retornan los registros

        mysqli_close($conn);//Se cierra la conexión
    
    }

    
    /*  
        Nombre de la función: consultarProductoXNombre
        Entrada: nombre del producto y id de la tienda
        Salida: Conteo

        Descripción: La función realiza un conteo de los productos cuyo nombre y id de la tienda sea igual a los datos de entrada.
    */
    function consultarProductoXNombre($nombreProducto, $idTienda){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Producto where nombreProd = '".$nombreProducto."' and idTienda = '".$idTienda."' ";
       
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado en un array
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el contador

        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: consultarProductoID
        Entrada: nombre del producto y i de la tienda
        Salida: Conteo

        Descripción: La función realiza un conteo de los productos cuyo nombre sea igual al del dato de entrada y que este sea diferente al id de la tienda
    */
    function consultarProductoID($nombreProducto, $idTienda){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza el conteo de los productos que tengan el nombre del producto y id de la tienda que indicó el usuario
        $sql  = "SELECT count(*) as contar from Producto where nombreProd = '".$nombreProducto."' and idTienda <> '".$idTienda."'";

        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado en un array
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el contador

        mysqli_close($conn);//Se cierra la conexión
    }

    
    /*  
        Nombre de la función: buscarProductoXId
        Entrada: Id del producto
        Salida: Conteo

        Descripción: La función realiza la búsqueda de un producto por su id. si este es encontrado se almacenará un 1.
    */
    function buscarProductoXId($idProd){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $sql  = "SELECT count(*) as contar from Producto where idProducto = '".$idProd."'";
        //Se ejecuta la sentencia sql
        $consulta =  mysqli_query($conn, $sql);

        //Se almacena el resultado en un array
        $array = mysqli_fetch_array($consulta);

        return $array['contar']; //Se retorna el contador

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: obtenerIdTienda
        Entrada: Id del producto
        Salida: Id de la tienda

        Descripción: La función realiza la búsqueda del id de la tienda de un producto.
    */
    function obtenerIdTienda($idProd){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se crea un query para mostrar datos del boleto seleccionado para modificar.
        $buscar = mysqli_query($conn,"SELECT idTienda from Producto WHERE idProducto ='".$idProd."'");

        //Se almacenan los datos de la consulta
        $datos = mysqli_fetch_array($buscar);

        //Se retorna el id de la tienda
        return $datos['idTienda'];

        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: agregarProducto
        Entrada: Nombre del producto, precio, descripción, imagen y id de la tienda
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de un nuevo producto con los datos enviados por el usuario.
    */
    function agregarProducto($nombreProducto, $precioProducto, $descProducto, $archivo, $idTienda){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "INSERT into Producto (idProducto, nombreProd, precioProd, descProd,imagenProd,idTienda) values (0,'".$nombreProducto."','".$precioProducto."','".$descProducto."','".$archivo."','".$idTienda."')";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: editarLocal
        Entrada: Bandera, nombre del producto, precio, descripción, imagen y id del producto
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la información del local con los datos enviados por el usuario.
    */
    function editarProducto($bandera, $nombreProducto, $precioProducto, $descProducto, $archivo, $idProducto){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //query que realiza la actualización del producto, si la bandera es igual a 1 este va a actualizar la imagen 
        if($bandera === 1){
            $query="UPDATE Producto SET  nombreProd = '".$nombreProducto."', precioProd = ".$precioProducto.", descProd= '".$descProducto."', imagenProd = '".$archivo."'   WHERE idProducto='".$idProducto."'";
        }else{
            $query="UPDATE Producto SET  nombreProd = '".$nombreProducto."', precioProd = ".$precioProducto.", descProd= '".$descProducto."'  WHERE idProducto='".$idProducto."'";
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
        Nombre de la función: eliminarProducto
        Entrada: Id del producto
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un producto indicado por el usuario
    */
    function eliminarProducto($idProd){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query para eliminar un producto
        $query = "DELETE FROM Producto WHERE idProducto='".$idProd."'";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn); //Se cierra la conexión con la bd.
    }
?>