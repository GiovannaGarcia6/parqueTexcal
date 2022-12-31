<?php
    function mostrarEmpleados($buscador,$idAdmin){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionEmpleado/funcionesEmpleado.php';


        $resultado = consultarEmpleadoBuscador($buscador);             
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
                    generarTablaEmpleados($resultado,$idAdmin);                   
                }
            }
        
    }

    function generarTablaEmpleados($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //En otro caso, se muestra la tabla con los registros.
        echo '<div class="table-responsive">';
        //Se muestran los datos encontrados de la busqueda
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>#</th>";
        echo "<th>Tipo</th>";
        echo "<th>Nombre</th>";
        echo "<th>Apellido Paterno</th>";
        echo "<th>Apellido Materno</th>";
        echo "<th>Correo</th>";
        echo "<th>Opciones</th>";
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
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='/sistema Web/presentacion/administrador/empleado/editarEmpleado.php?id=".$id."&idTrabajador=".$row['0']."'> <button type='button' class='btn btn-primary'><i class='fa-solid fa-pencil'></i></button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$id."' data-bs-idTrabajador='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash-can'></i></button></td>";
            echo "</tr>"; 
        }
        echo "</table>";  
        echo '</div>'; 
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }
?>
                