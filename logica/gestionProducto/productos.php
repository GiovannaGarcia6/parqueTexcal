<?php
    /*
        Nombre de la función: mostrarProductos
        Entrada: Frase o palabra a buscar, id del vendedor y id de la tienda

        Descripción: La función permite realizar la búsqueda de productos que coincidan con
        lo que se envío del buscador para posteriormente, realizar una verificación de los resultados
        retornados. Si el resultado tiene errores se debe mandar un mensaje al usuario, sino contiene
        ningún error se verifica si existen filas, los cuales son los registros. Si el número de
        filas es igual a 0 indica que no hay registros y que se debe mostrar un mensaje al usuario, 
        en caso de que si existan resultados se realiza la llamada a la función correspondiente para
        generar mostrar los datos.
    */
    function mostrarProductos($buscador,$idVendedor, $idTienda){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionProducto/funcionesProducto.php';

        $resultado = buscadorProductos($buscador,$idTienda);             
        //Se verifica que no existan errores en la consulta

        if (!$resultado){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            //Se obtiene el numero de filas que tuvo el resultado del query.
            $numfilas = $resultado->num_rows;

            //Si es igual a 0 indica que no existe un registro que contenga lo que el 
            //usuario ingreso en el buscador
        
            if($numfilas===0){
                //Alerta para cuando no se encuentran registros
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay productos.</div><br>';  
            }else{
                generarTablaProductos($resultado,$idVendedor);                   
            }
        }
        
    }

    /*
        Nombre de la función: mostrarProductosHome
        Entrada: Id de la tienda

        Descripción: La función permite realizar la búsqueda de productos que coincidan con
        el id de la tienda para posteriormente realizar una verificación de los resultados
        retornados. Si el resultado tiene errores se debe mandar un mensaje al usuario, sino contiene
        ningún error se verifica si existen filas, los cuales son los registros. Si el número de
        filas es igual a 0 indica que no hay registros y que se debe mostrar un mensaje al usuario, 
        en caso de que si existan resultados se realiza la llamada a la función correspondiente para
        generar mostrar los datos.
    */
    function mostrarProductosHome($idTienda){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionProducto/funcionesProducto.php';

        $resultado = buscadorProductos("",$idTienda);            
        //Se verifica que no existan errores en la consulta

        if (!$resultado){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            //Se obtiene el numero de filas que tuvo el resultado del query.
            $numfilas = $resultado->num_rows;

            //Si es igual a 0 indica que no existe un registro que contenga lo que el 
            //usuario ingreso en el buscador
        
            if($numfilas===0){
                //Alerta para cuando no se encuentran registros
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay productos.</div><br>';  
            }else{
                generarProductosHome($resultado);                   
            }
        }
        
    }

    /*
        Nombre de la función: generarTablaProductos
        Entrada: Resultado de la consulta y id del vendedor

        Descripción: La función permite mostrar una tabla con los registros que se obtuvieron de
        la consulta.
    */
    function generarTablaProductos($resultado,$idVendedor){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Nombre del Producto </th>";
        echo "<th>Precio</th>";
        echo "<th>Descripción</th>";
        echo "<th>Imagen</th>";
        echo "<th></th>";
        echo "<th>Editar</th>";
        echo "<th>Eliminar</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //id del producto
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del producto
            echo "<td>"; echo $row[2]; echo "</td>"; //precio del producto
            echo "<td>"; echo $row[3]; echo "</td>"; //descripción del producto
            echo "<td>"; echo '<img  style="width:128px; height:128px" src="data:image/jpeg;base64,'.base64_encode( $row[4] ).'"/>';  echo "<td>";//imagen del producto
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id del producto
            echo "<td> <a href='editarProducto.php?id=".$row['0']."&idTrab=".$idVendedor."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id del producto
            echo "<td> <button type='button' class='btn btn-danger' data-bs-idVendedor='".$idVendedor."' data-bs-id='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";    
        echo '</div>';              
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

    /*
        Nombre de la función: generarProductosHome
        Entrada: Resultado de la consulta y id del vendedor

        Descripción: La función permite mostrar un contenedor con los datos de los productos que se obtuvieron de
        la consulta.
    */

    function generarProductosHome($resultado){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo "<div class='row'>";
        //Se muestran los datos encontrados de la búsqueda
        while ($row = mysqli_fetch_row($resultado)){
?>
            <div class="col-12 col-md-4 card cardProducto text-center">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $row[1];?></h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?php  echo '<img  style="width:128px; height:128px" src="data:image/jpeg;base64,'.base64_encode( $row[4] ).'"/>'; ?></p>
                    <p class="card-text"><?php  echo $row[3]; ?></p>
                </div>
                <div class="card-footer text-muted">
                    <?php 
                        echo "<span> <b> Precio: </b>$";
                        
                        echo $row[2]; echo ".00</span>"; 
                    ?>
                </div>
            </div> 
<?php             
        }
        echo "</div>";           
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

?>