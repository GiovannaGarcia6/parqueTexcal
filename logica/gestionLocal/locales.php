<?php
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

    function generarTablaLocales($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';


            //En otro caso, se muestra la tabla con los registros.
            echo "<table class='table table-striped table-hover'>";
            //Se muestra los nombres de cada columna de la tabla
            echo "<thead>";
            echo "<th>#</th>";
            echo "<th>Nombre del local </th>";
            echo "<th>Editar</th>";
            echo "<th>Eliminar</th>";
            echo "</thead>"; 
            //Se muestran los datos encontrados de la busqueda
            while ($row = mysqli_fetch_row($resultado)){
                echo "<tr>";
                echo "<td>"; echo $row[0]; echo "</td>"; //id del negocio
                echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
                //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
                echo "<td> <a href='editarLocal.php?id=".$row['0']."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
                //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
                echo "<td> <button type='button' class='btn btn-danger' data-bs-idVendedor='".$id."' data-bs-id='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
                echo "</tr>"; 
            }
            echo "</table>";                   
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

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