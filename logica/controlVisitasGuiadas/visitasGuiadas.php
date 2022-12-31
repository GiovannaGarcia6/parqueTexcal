<?php
     function mostrarVisitasVisitante($buscador,$idVisitante,$estadoVisita){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

        $resultado = buscadorVisitas($buscador,$idVisitante,$estadoVisita);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">Por el momento no hay visitas.</div><br>';  
            }else{
                if($estadoVisita === 'En espera'){
                    generarTablaVisitasEnEspera($resultado,$idVisitante);                   
                }else{
                    generarTablaVisitasPendientes($resultado,$idVisitante);   
                }
            }
        }
        
    }

    function generarTablaVisitasEnEspera($resultado,$idVisitante){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        echo '<div class="table-responsive">';
        //Se muestran los datos encontrados de la busqueda
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Fecha de la visita</th>";
        echo "<th>Estado de la visita</th>";
        echo "<th>Correo del guía</th>";
        echo "<th>Cancelar visita</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[3]; echo "</td>"; //nombre del negocio
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$idVisitante."' data-bs-idVisita='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalCancelar'>Cancelar</button></td>";
            echo "</tr>"; 
        }
        echo "</table>";  
        echo '</div>';                
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function generarTablaVisitasPendientes($resultado,$idVisitante){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        //Se muestran los datos encontrados de la busqueda
        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Fecha de la visita</th>";
        echo "<th>Estado de la visita</th>";
        echo "<th>Correo del guía</th>";
        echo "<th>Chat con el guía</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[3]; echo "</td>"; //nombre del negocio
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <a href='../chat/chat.php?idVisita=".$row['0']."&id=".$idVisitante."&tipo=2'> <button type='button' class='btn btn-success'><i class='fa-solid fa-comments'></i> Ingresar al chat</button> </a> </td>";                                   
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';    
    }


    function mostrarVisitasGuia($buscador,$idTrab,$estadoVisita){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

        $resultado = buscadorVisitasGuia($buscador,$idTrab,$estadoVisita);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">Por el momento no hay visitas.</div><br>';  
            }else{
                if($estadoVisita === 'En espera'){
                    generarTablaVisitasEnEsperaGuia($resultado,$idTrab);                   
                }else{
                    generarTablaVisitasPendientesGuia($resultado,$idTrab);   
                }
            }
        }
        
    }

    function generarTablaVisitasEnEsperaGuia($resultado,$idTrab){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Fecha de la visita</th>";
        echo "<th>Correo del visitante</th>";
        echo "<th>Aceptar visita</th>";
        echo "<th>Rechazar visita</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<td> <a href='../../../logica/controlVisitasGuiadas/aceptarVisita.php?idVisita=".$row['0']."&id=".$idTrab."'> <button type='button' class='btn btn-success'>Aceptar</button> </a> </td>";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$idTrab."' data-bs-idVisita='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalCancelar'>Rechazar</button></td>";
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';                      
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

    function generarTablaVisitasPendientesGuia($resultado,$idTrab){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        echo '<div class="table-responsive">';
        //Se muestran los datos encontrados de la busqueda
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Fecha de la visita</th>";
        echo "<th>Correo del visitante</th>";
        echo "<th>Chat con el visitante</th>";
        echo "<th>Finalizar visita</th>";
        echo "<th>Cancelar visita</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "<td>"; echo $row[2]; echo "</td>"; //nombre del negocio
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<td> <a href='../chat/chat.php?idVisita=".$row['0']."&id=".$idTrab."&tipo=1'> <button type='button' class='btn btn-success'><i class='fa-solid fa-comments'></i> Ingresar al chat</button> </a> </td>";                                    
            echo "<td> <button type='button' class='btn btn-primary' data-bs-id='".$idTrab."' data-bs-idVisita='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalFinalizar'><i class='fa-solid fa-check'></i> Finalizar</button></td>";
            echo "<td> <button type='button' class='btn btn-danger' data-bs-id='".$idTrab."' data-bs-idVisita='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalCancelar'><i class='fa-solid fa-x'></i> Cancelar</button></td>";
            echo "</tr>"; 
        }
        echo "</table>";  
        echo '</div>';      
    }


    function mostrarCorreos(){
       
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

        $ejecutar = consultarTrabajadores();
        
        foreach ($ejecutar as $opciones): 
        ?> 
            <option value="<?php echo $opciones['correoTrab']?>"><?php echo $opciones['correoTrab']?></option>
        <?php
        endforeach;   
    }
?>