<?php
    function mostrarMantenimientos($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';

        $resultado = buscadorMantenimientos($buscador);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay mantenimientos.</div><br>';  
            }else{
                generarTablaMantenimientos($resultado,$id);                   
            }
        }
        
    }

    function generarTablaMantenimientos($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        echo '<div class="table-responsive">';
        //Se muestran los datos encontrados de la busqueda
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Nombre Mantenimiento</th>";
        echo "<th>Descripción</th>";
        echo "<th>Ver tareas</th>";
        echo "<th>Editar</th>";
        echo "<th>Eliminar</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='tareas.php?id=".$id."&idMantenimiento=".$row['0']."'> <button type='button' class='btn btn-warning'><i class='fa-solid fa-file-lines' style='color:white'></i></button> </a> </td>";
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='editarMantenimiento.php?id=".$id."&idMantenimiento=".$row['0']."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$id."' data-bs-idMantenimiento='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";  
        echo '</div>';                 
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

    function mostrarTareas($buscador,$idMantenimiento, $id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';

        $resultado = buscadorTareas($buscador, $idMantenimiento);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay tareas.</div><br>';  
            }else{
                generarTablaTareas($resultado,$id,$idMantenimiento);                   
            }
        }
        
    }

    function generarTablaTareas($resultado,$id, $idMantenimiento){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Título tarea</th>";
        echo "<th>Descripción</th>";
        echo "<th>Estado</th>";
        echo "<th>Fecha inicio</th>";
        echo "<th>Fecha termino</th>";
        echo "<th>Correo responsable</th>";
        echo "<th>Editar</th>";
        echo "<th>Eliminar</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[3]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[4]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[5]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[6]; echo "</td>"; //nombre del negocio
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='editarTarea.php?idTarea=".$row['0']."&id=".$id."&idMantenimiento=".$idMantenimiento."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <button type='button' class='btn btn-danger' data-bs-idAdmin='".$id."' data-bs-idMantenimiento='".$idMantenimiento."' data-bs-idTarea='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";    
        echo '</div>';             
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function mostrarTareasEmpleado($buscador,$idEmpleado){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';

        $resultado = buscadorTareasEmpleado($buscador, $idEmpleado);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay tareas.</div><br>';  
            }else{
                generarTablaTareasEmpleado($resultado,$idEmpleado);                   
            }
        }
        
    }
    function generarTablaTareasEmpleado($resultado,$idEmpleado){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Título tarea</th>";
        echo "<th>Descripción</th>";
        echo "<th>Estado</th>";
        echo "<th>Fecha inicio</th>";
        echo "<th>Fecha termino</th>";
        echo "<th>Cambiar estado</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[3]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[4]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[5]; echo "</td>"; //nombre del negocio

            if($row[3] === 'En proceso'){
                echo "<td> <button type='button' class='btn btn-primary' data-bs-idEmpleado='".$idEmpleado."' data-bs-idTarea='".$row[0]."' data-bs-estado='1' data-bs-toggle='modal' data-bs-target='#modalCambiarEstado'><i class='fa-solid fa-check'></i> Finalizada</button></td>";

            }else{
                echo "<td> <button type='button' class='btn btn-warning' data-bs-idEmpleado='".$idEmpleado."' data-bs-idTarea='".$row[0]."' data-bs-estado='2' data-bs-toggle='modal' data-bs-target='#modalCambiarEstado'><i class='fa-solid fa-hammer'></i> En proceso</button></td>";

            }
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';  
         
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }
?>