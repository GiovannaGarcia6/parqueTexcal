<?php
    function mostrarBoletos($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';


        $resultado = buscadorBoleto($buscador);             
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

            if($numfilas==0){
                //Alerta para cuando no se encuentran registros
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay registros.</div><br>';  
            }else{
                generarTablaBoletos($resultado,$id);
            }
        }
        
    }

    function generarTablaBoletos($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //En otro caso, se muestra la tabla con los registros.
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Boleto </th>";
        echo "<th>Precio</th>";
        echo "<th>Servicio</th>";
        echo "<th>Editar</th>";
        echo "<th>Eliminar</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //idTarifa
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre de la tarifa
            echo "<td>"; echo $row[2]; echo "</td>"; //precio de la tarifa
            echo "<td>"; echo $row[3]; echo "</td>"; //nombre del servicio
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='editarBoleto.php?id=".$id."&idBoleto=".$row['0']."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$id."' data-bs-idBoleto='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

    

    function mostrarServicio($nombreServicio){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        $resultado=servicios();
                 
        while ($servicio = mysqli_fetch_assoc($resultado)) {
            if($servicio['nombServ'] != 'Parque'){
                echo "<option value='".$servicio['idServicio']."'";
                //Si es el mismo id que se obtuvo al inicio se muestra como seleccionada.
                if($nombreServicio === $servicio['nombServ']){
                    echo ' selected="selected"';
                }
                echo ">".$servicio['nombServ']."</option>";
            }
            
        }
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }


    function mostrarBoletosServicio($idServicio){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';


        $resultado = boletosServicios($idServicio);             
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

            if($numfilas==0){
                //Alerta para cuando no se encuentran registros
                echo '<div id="alerta" class="alert alert-warning d-flex align-items-center" role="alert"  style="margin-top:10px;">El servicio es gratuito.</div><br>';  
            }else{
                generarBoletosServicios($resultado);
            }
        }
    }


    function generarBoletosServicios($resultado){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        while ($row = mysqli_fetch_row($resultado)){

            echo "<div class='col-xs-12 col-sm-12 col-md-4 tarifa'>";
            echo "<div class='cabeceraTarifa'>";
            echo "<p>"; echo $row[0]; echo "</p>";
            echo "</div>";
            echo "<div class='cuerpoTarifa'>";
            echo "<p class='card-title'>"; echo "$".$row[1]; echo "</p>";
            echo "</div>";
            echo "</div>";
        }
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

?>