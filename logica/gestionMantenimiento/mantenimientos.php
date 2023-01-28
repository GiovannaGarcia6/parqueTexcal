<?php
    /*
        Nombre de la función: mostrarMantenimientos
        Entrada: Frase o palabra a buscar, id del admin

        Descripción: La función permite realizar la búsqueda de los mantenimientos que coincidan con
        lo que se envío del buscador, para luego realizar una verificación de los resultados
        retornados. Si el resultado tiene errores se debe mandar un mensaje al usuario, sino contiene
        ningún error se verifica si existen filas, los cuales son los registros. Si el número de
        filas es igual a 0 indica que no hay registros y que se debe mostrar un mensaje al usuario, 
        en caso de que si existan resultados se realiza la llamada a la función correspondiente para
        generar mostrar los datos.
    */
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

    /*
        Nombre de la función: generarTablaMantenimientos
        Entrada: Resultado de la consulta y id del administrador

        Descripción: La función permite mostrar una tabla con los registros que se obtuvieron de
        la consulta.
    */
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
        //Se muestran los datos encontrados de la búsqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //id del mantenimiento
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del mantenimiento
            echo "<td>"; echo $row[2]; echo "</td>"; //descripción
            //Se crea un enlace con un botón para ver las tareas correspondientes a este mantenimmiento
            echo "<td> <a href='tareas.php?id=".$id."&idMantenimiento=".$row['0']."'> <button type='button' class='btn btn-warning'><i class='fa-solid fa-file-lines' style='color:white'></i></button> </a> </td>";
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id del mantenimiento
            echo "<td> <a href='editarMantenimiento.php?id=".$id."&idMantenimiento=".$row['0']."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-idMantenimiento, el id del mantenimiento
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$id."' data-bs-idMantenimiento='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";  
        echo '</div>';                 
    }

    /*
        Nombre de la función: mostrarTareas
        Entrada: Frase o palabra a buscar, id del admin

        Descripción: La función permite realizar la búsqueda de las tareas que coincidan con
        lo que se envío del buscador y que pertenezcan al id del mantenimiento indicado.
    */
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

    /*
        Nombre de la función: generarTablaTareas
        Entrada: Resultado de la consulta y id del administrador

        Descripción: La función permite mostrar una tabla con las tareas que se obtuvieron 
        de acuerdo con la consulta.
    */
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
            //Se crea un enlace con un botón para editar, el cual redirige a la página para editar la tarea
            echo "<td> <a href='editarTarea.php?idTarea=".$row['0']."&id=".$id."&idMantenimiento=".$idMantenimiento."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando datos como el id del admin, el id del mantenimiento y el id de la tarea
            echo "<td> <button type='button' class='btn btn-danger' data-bs-idAdmin='".$id."' data-bs-idMantenimiento='".$idMantenimiento."' data-bs-idTarea='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";    
        echo '</div>';             
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

    /*
        Nombre de la función: mostrarTareasEmpleado
        Entrada: Frase o palabra a buscar, id del admin

        Descripción: La función permite realizar la búsqueda de las tareas que coincidan con
        lo que se envío del buscador y que pertenezcanal id del trabajador
    */
    function mostrarTareasEmpleado($buscador,$idTrabajador){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionMantenimiento/funcionesMantenimiento.php';

        $resultado = buscadorTareasEmpleado($buscador, $idTrabajador);             
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
                generarTablaTareasEmpleado($resultado,$idTrabajador);                   
            }
        }
        
    }

    /*
        Nombre de la función: generarTablaTareasEmpleado
        Entrada: Resultado de la consulta y id del administrador

        Descripción: La función permite mostrar una tabla con las tareas de un empleado 
        que se obtuvieronde acuerdo con la consulta.
    */
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
            echo "<td>"; echo $row[0]; echo "</td>"; //id de la tarea
            echo "<td>"; echo $row[1]; echo "</td>"; //titulo
            echo "<td>"; echo $row[2]; echo "</td>"; //descripción
            echo "<td>"; echo $row[3]; echo "</td>"; //estado de la tarea
            echo "<td>"; echo $row[4]; echo "</td>"; //fecha de inicio
            echo "<td>"; echo $row[5]; echo "</td>"; //fecha de termino

            //En esta parte, se verifica el estado de la tarea, ya que de acuerdo a lo que se tenga se mostrará el botón
            //Si es "En proceso" el botón que se mostrará es Finalizada y si es otro se dejará el botón de en proceso.
            if($row[3] === 'En proceso'){
                echo "<td> <button type='button' class='btn btn-primary' data-bs-idEmpleado='".$idEmpleado."' data-bs-idTarea='".$row[0]."' data-bs-estado='1' data-bs-toggle='modal' data-bs-target='#modalCambiarEstado'><i class='fa-solid fa-check'></i> Finalizada</button></td>";
            }else{
                echo "<td> <button type='button' class='btn btn-warning' data-bs-idEmpleado='".$idEmpleado."' data-bs-idTarea='".$row[0]."' data-bs-estado='2' data-bs-toggle='modal' data-bs-target='#modalCambiarEstado'><i class='fa-solid fa-hammer'></i> En proceso</button></td>";

            }
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';  
    }
?>