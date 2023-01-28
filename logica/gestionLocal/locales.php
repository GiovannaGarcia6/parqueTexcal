<?php
    
    /*
        Nombre de la función: mostrarLocales
        Entrada: Frase o palabra a buscar, id del vendedor
    
        Descripción: La función permite realizar la búsqueda de los locales que coincidan con
        lo que se envío del buscador y que sean del id del vendedor para posteriormente, realizar 
        una verificación de los resultados retornados. Si el resultado tiene errores se debe mandar 
        un mensaje al usuario, sino contiene ningún error se verifica si existen filas, los cuales
        son los registros. Si el número de filas es igual a 0 indica que no hay registros y que 
        se debe mostrar un mensaje al usuario, en caso de que si existan resultados se realiza la
        llamada a la función correspondiente para generar mostrar los datos.
    */
    function mostrarLocales($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';

        $resultado = buscadorLocales($buscador,$id);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay locales.</div><br>';  
            }else{
                generarTablaLocales($resultado,$id);                   
            }
        }
        
    }

    /*
        Nombre de la función: generarTablaLocales
        Entrada: Resultado de la consulta y id del vendedor
        Salida: Tabla con los registros de los locales

        Descripción: La función permite mostrar una tabla con los datos de los locales que el vendedor tenga registrados.
    */
    function generarTablaLocales($resultado,$idVendedor){
        //Se muestra la tabla con los registros.
        echo "<table class='table table-striped table-hover'>";
        //Nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Nombre del local </th>";
        echo "<th>Editar</th>";
        echo "<th>Eliminar</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //Id del negocio
            echo "<td>"; echo $row[1]; echo "</td>"; //Nombre del negocio
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='editarLocal.php?id=".$row['0']."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id del negocio y en  data-bs-idVendedor, el id del vendedor
            echo "<td> <button type='button' class='btn btn-danger' data-bs-idVendedor='".$idVendedor."' data-bs-id='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";                             
    }


    /*
        Nombre de la función: mostrarLocales
        Entrada: Frase o palabra a buscar, id del vendedor
    
        Descripción: La función permite realizar la búsqueda de los locales que coincidan con
        lo que se envío del buscador y que sean del id del vendedor.
    */
    function mostrarLocalesProductos($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';

        $resultado = buscadorLocales($buscador,$id);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay locales.</div><br>';  
            }else{
                generarLocalesEnlace($resultado,$id);                   
            }
        }
    }

    /*
        Nombre de la función: generarLocalesEnlace
        Entrada: Resultado de la consulta y id del vendedor
        Salida: Tabla con los registros de los locales

        Descripción: La función permite mostrar un contenedor por cada registro.
        En cada contenedor se mostrará un icono con el nombre del negocio.
    */
    function generarLocalesEnlace($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo "<div class='row'>";
        while ($row = mysqli_fetch_row($resultado)){
        ?>
            <div class="card shop col-11 col-sm-5 col-md-2">
                <a id="negocioEnlace" href="./productos.php?id=<?php echo $id;?>&idTienda=<?php echo  $row[0]; ?>" class="card-header border-success">
                    <center>
                        <i class="fa-solid fa-shop" style="color:#006101; font-size:60px"></i><br>
                        <h5 class="card-title"><?php echo $row[1];?></h5>
                    </center>
                </a>
            </div>    
        <?php 
        }
        echo "</div>";      
    }

    /*
        Nombre de la función: mostrarLocales
        Entrada: Sin parámetros
    
        Descripción: La función permite realizar una consulta de los locales almacenados en la base de datos 
        y posteriormente, realizar el llamado a la función que deberá generar los locales con los enlaces correspondientes 
        para mostrar los productos de cada uno.
    */
    function verLocales(){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionLocal/funcionesLocal.php';

        $resultado = verLocalesHome();             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay locales.</div><br>';  
            }else{
                generarLocalesEnlaces($resultado);                   
            }
        }
        
    }

    /*
        Nombre de la función: generarLocalesEnlace
        Entrada: Resultado de la consulta y id del vendedor
        Salida: Tabla con los registros de los locales

        Descripción: La función permite mostrar un contenedor por cada registro.
        En cada contenedor se mostrará un icono con el nombre del negocio.
        La generación de estos locales se mostrarán en la sección del balneario.
    */

    function generarLocalesEnlaces($resultado){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo "<div class='row'>";
        while ($row = mysqli_fetch_row($resultado)){
        ?>
            <div class="card shop col-11 col-sm-5 col-md-5">
                <a id="negocioEnlace" href="./productosLista.php?id=<?php echo  $row[0]; ?>" class="card-header border-primary negocioEnlace">
                    <center>
                        <i class="fa-solid fa-shop" style="color:#005DBB; font-size:60px"></i><br>
                        <h5 class="card-title"><?php echo $row[1];?></h5>
                    </center>
                </a>
            </div>    
        <?php 
        }
        echo "</div>";      
    }


?>