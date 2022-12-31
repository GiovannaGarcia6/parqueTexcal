<?php
    function mostrarResultados($idAdmin, $seccion, $parametro1, $parametro2){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';
      

        if($seccion === "Comentarios"){ 
            $resultadoComentarios = mostrarComentarios($parametro1, $parametro2);
            if (!$resultadoComentarios){
                //Si existen se manda un mensaje con el error que ocurrió en la consulta.
                echo "<br>";
                echo "La consulta SQL contiene errores.";
                exit();
            }else{
                //Se obtiene el numero de filas que tuvo el resultado del query.
                $numfilas = $resultadoComentarios->num_rows;
    
                //Si es igual a 0 indica que no existe un registro que contenga lo que el 
                //usuario ingreso en el buscador
            
                if($numfilas===0){
                    //Alerta para cuando no se encuentran registros
                    echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay resultados.</div><br>';  
                }else{
                    generarTablaComentarios($resultadoComentarios, $parametro1, $parametro2, $idAdmin, $seccion);                   
                }
            }
        }else{
            if($parametro1 > $parametro2){
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">La fecha de inicio debe ser mayor a la fecha de termino.</div><br>';  
            }else{
                $resultadoMantenimientos = mostrarMantenimientos($parametro1, $parametro2);
                
                if (!$resultadoMantenimientos){
                    //Si existen se manda un mensaje con el error que ocurrió en la consulta.
                    echo "<br>";
                    echo "La consulta SQL contiene errores.";
                    exit();
                }else{
                    //Se obtiene el numero de filas que tuvo el resultado del query.
                    $numfilas = $resultadoMantenimientos->num_rows;
        
                    //Si es igual a 0 indica que no existe un registro que contenga lo que el 
                    //usuario ingreso en el buscador
                
                    if($numfilas===0){
                        //Alerta para cuando no se encuentran registros
                        echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay resultados.</div><br>';  
                    }else{
                        generarTablaMantenimientos($resultadoMantenimientos, $parametro1, $parametro2);                   
                    }
                }
            }
        }

        

        
       
        
    }


    function generarTablaComentarios($resultado, $parametro1, $parametro2, $idAdmin, $seccion){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        
    ?>
        <script>
            google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                    
                    var data = google.visualization.arrayToDataTable([
                    ['Puntuacion', '%'],
                    <?php 
                       $conteoComentarios = contarComentarios($parametro1);

                    
                       echo "['Comentarios positivos', ".$conteoComentarios[0]."],";
                       echo "['Comentarios negativos', ".$conteoComentarios[1]."],";
                    ?>
                
                    ]);

                    var options = { is3D: true,};

                    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
                    chart.draw(data, options);

                    document.getElementById('variableReporte').value=chart.getImageURI();
                }
        
        </script>
        <form method="post" action="reporteComentarios.php" target='_blank' class="col-11">

            <button type="submit" class="btn btn-danger btnPDF"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>

            <input type="hidden" name="variableReporte" id="variableReporte">
            <input type="hidden" name="servicio" id="servicio" value="<?php echo $parametro1;?>">
            <input type="hidden" name="filtro" id="filtro" value="<?php echo $parametro2;?>" >
            <input type="hidden" name="seccion" id="seccion"  value="<?php echo $seccion;?>">
            <input type="hidden" name="idAdmin" id="idAdmin" value="<?php echo $idAdmin;?>">
            <br>
            <br>
            <br>
            <h3>Gráfica de comentarios</h3>
            <div id="grafico"></div>

        </form>

       
    <?php
        echo '<h3>Comentarios</h3>';

        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Servicio</th>";
        echo "<th>Calificacion</th>";
        echo "<th>Comentario</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //nombre del negocio
           
            echo "<td> <span>"; 

            for($estrellas=0; $estrellas<$row[2];$estrellas++){
                echo "<i class='fa-solid fa-star' style='color:#FFD607;' ></i> ";
            }
            
            echo $row[2]; echo " Estrella(s)</span></td>"; 
            echo "<td>"; echo $row[1]; echo "</td>"; //nombre del negocio
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';  

       
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function contarComentarios($servicio){
      
        $resComentariosPositivos = contarComentariosPositivos($servicio);
        $resComentariosNegativos = contarComentariosNegativos($servicio);


        if (!$resComentariosPositivos && !$resComentariosNegativos){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            $conteo = [
                0 => "".$resComentariosPositivos,
                1 => "".$resComentariosNegativos,
            ];
            return $conteo;
        }
    }


    function generarTablaMantenimientos($resultado, $fechaInicio, $fechaTermino){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php'; 
        
    ?>
        <script>
            google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                    
                    var data = google.visualization.arrayToDataTable([
                    ['Puntuacion', '%'],
                    <?php 
                       $contarTareas = contarTareasXEstatus($fechaInicio, $fechaTermino);
                    
                       echo "['Pendientes', ".$contarTareas[0]."],";
                       echo "['En proceso', ".$contarTareas[1]."],";
                       echo "['Finalizadas', ".$contarTareas[2]."],";
                    ?>
                
                    ]);

                    var options = { is3D: true,};

                    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
                    chart.draw(data, options);

                    document.getElementById('variableReporte').value=chart.getImageURI();
                }
        
        </script>
        <form method="post" action="reporteMantenimientos.php" target='_blank' class="col-11">

            <button type="submit" class="btn btn-danger btnPDF"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>

            <input type="hidden" name="variableReporte" id="variableReporte">
            <input type="hidden" name="fechaInicio" id="fechaInicio" value="<?php echo $fechaInicio;?>">
            <input type="hidden" name="fechaTermino" id="fechaTermino" value="<?php echo $fechaTermino;?>" >
           
            <br>
            <br>
            <br>
            <h3>Gráfica de mantenimientos</h3>
            <div id="grafico"></div>

        </form>

       
    <?php
        echo '<h3>Actividades</h3>';

        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Mantenimiento</th>";
        echo "<th>Actividad</th>";
        echo "<th>Descripcion</th>";
        echo "<th>Estatus</th>";
        echo "<th>Fecha de inicio</th>";
        echo "<th>Fecha de termino</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; 
            echo "<td>"; echo $row[1]; echo "</td>"; 
            echo "<td>"; echo $row[2]; echo "</td>"; 
            echo "<td>"; echo $row[3]; echo "</td>";
            echo "<td>"; echo $row[4]; echo "</td>";
            echo "<td>"; echo $row[5]; echo "</td>";
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';  

        $resultadoMejorTrabajador = mejorEmpleado($fechaInicio, $fechaTermino);

        if (!$resultadoMejorTrabajador){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{

            echo '<h3>Mejor empleado de mantenimiento</h3>';
            while ($row = mysqli_fetch_row($resultadoMejorTrabajador)){
                $contarTareas = $row[4];
                if($contarTareas==='0'){
                    //Alerta para cuando no se encuentran registros
                    echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay mejor empleado en tareas finalizadas.</div><br>';  
                }else{
                    
                    echo "<span><b>Nombre del empleado:</b> ".$row[0]." ".$row[1]." ".$row[2]."</span>";
                    echo "<span><b>Correo:</b> ".$row[3]."</span>";
                    echo "<span><b>Total de actividades finalizadas:</b> ".$row[4]."</span>"; 
                
                    
                }
            }

            

            
        }
        mysqli_close($conn);//Se cierra la conexión con la bd.  
        
        

    }



    function contarTareasXEstatus($fechaInicio, $fechaTermino){
      
        $resTareasPendientes = contarTareas("Pendiente", $fechaInicio, $fechaTermino);
        $resTareasEnProceso = contarTareas("En proceso", $fechaInicio, $fechaTermino);
        $resTareasFinalizadas = contarTareas("Finalizada", $fechaInicio, $fechaTermino);

        if (!$resTareasEnProceso && !$resTareasFinalizadas && !$resTareasPendientes){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            $conteo = [
                0 => "".$resTareasPendientes,
                1 => "".$resTareasEnProceso,
                2 => "".$resTareasFinalizadas,
            ];
            return $conteo;
        }
    }

    function mostrarResultadosGuia($idGuia, $parametro1, $parametro2){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/reportes/funcionesReportes.php';
      
        if($parametro1 > $parametro2){
            echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">La fecha de inicio debe ser mayor a la fecha de termino.</div><br>';  
        }else{
            $resultadoVisitas= mostrarVisitas($idGuia, $parametro1, $parametro2);
            
            if (!$resultadoVisitas){
                //Si existen se manda un mensaje con el error que ocurrió en la consulta.
                echo "<br>";
                echo "Hola 2";
                echo "La consulta SQL contiene errores.";
                exit();
            }else{
                //Se obtiene el numero de filas que tuvo el resultado del query.
                $numfilas = $resultadoVisitas->num_rows;
    
                //Si es igual a 0 indica que no existe un registro que contenga lo que el 
                //usuario ingreso en el buscador
            
                if($numfilas===0){
                    //Alerta para cuando no se encuentran registros
                    echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay resultados.</div><br>';  
                }else{
                    generarTablaVisitas($resultadoVisitas, $parametro1, $parametro2, $idGuia);                   
                }
            }
        }
    }




    function generarTablaVisitas($resultado, $fechaInicio, $fechaTermino, $idGuia){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php'; 
        
    ?>
        <script>
            google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                    
                    var data = google.visualization.arrayToDataTable([
                    ['Puntuacion', '%'],
                    <?php 
                       $contarVisitas = contarVisitasXEstatus($idGuia, $fechaInicio, $fechaTermino);
                    
                       echo "['Pendientes', ".$contarVisitas[0]."],";
                       echo "['En espera', ".$contarVisitas[1]."],";
                       echo "['Finalizadas', ".$contarVisitas[2]."],";
                    ?>
                
                    ]);

                    var options = { is3D: true,};

                    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
                    chart.draw(data, options);

                    document.getElementById('variableReporte').value=chart.getImageURI();
                }
        
        </script>
        <form method="post" action="reportevisitas.php" target='_blank' class="col-11">

            <button type="submit" class="btn btn-danger btnPDF"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>

            <input type="hidden" name="variableReporte" id="variableReporte">
            <input type="hidden" name="fechaInicio" id="fechaInicio" value="<?php echo $fechaInicio;?>">
            <input type="hidden" name="fechaTermino" id="fechaTermino" value="<?php echo $fechaTermino;?>" >
            <input type="hidden" name="idGuia" id="idGuia" value="<?php echo $idGuia;?>" >
            <br>
            <br>
            <br>
            <h3>Gráfica de visitas guiadas</h3>
            <div id="grafico"></div>

        </form>

       
    <?php
        echo "<span><b>Pendientes:</b> ".$contarVisitas[0]."</span>";
        echo "<span><b>En espera:</b> ".$contarVisitas[1]."</span>";
        echo "<span><b>Finalizadas:</b> ".$contarVisitas[2]."</span>";
    
        echo "<br><br>";
        echo '<h3>Visitas guiadas finalizadas</h3>';

        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Fecha</th>";
        echo "<th>Estado</th>";
        echo "<th>Visitante</th>";
        echo "<th>Correo</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; 
            echo "<td>"; echo $row[1]; echo "</td>"; 
            echo "<td>"; echo $row[2]." ".$row[3]." ".$row[4]; echo "</td>"; 
            echo "<td>"; echo $row[5]; echo "</td>";
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';  

       
        mysqli_close($conn);//Se cierra la conexión con la bd.  
        
        

    }

    function contarVisitasXEstatus($idGuia, $fechaInicio, $fechaTermino){
      
        $resVisitasPendientes = contarVisitas("Pendiente", $fechaInicio, $fechaTermino, $idGuia);
        $resVisitasEnEspera = contarVisitas("En espera", $fechaInicio, $fechaTermino, $idGuia);
        $resVisitasFinalizadas = contarVisitas("Finalizada", $fechaInicio, $fechaTermino, $idGuia);

        if (!$resVisitasEnEspera && !$resVisitasPendientes && !$resVisitasFinalizadas){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "Hola";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            $conteo = [
                0 => "".$resVisitasPendientes,
                1 => "".$resVisitasEnEspera,
                2 => "".$resVisitasFinalizadas,
            ];
            return $conteo;
        }
    }
    function contarTodasVisitasGuiadas($idGuia, $fechaInicio, $fechaTermino){
      
        $resVisitas = contarTodasVisitas($fechaInicio, $fechaTermino, $idGuia);
   
        if (!$resVisitas){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "Hola 3";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            echo "<span>El total de visitas guiadas son <b>".$resVisitas. "</b> en un periodo de <b>".$fechaInicio. "</b> a <b>".$fechaTermino."</b>.</span>";
        }
    }



?>