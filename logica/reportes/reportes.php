<?php

    /* 
        Nombre de la función: mostrarResultados
        Entrada: id del administrador, la sección a la que se le aplican los filtros, y los parametros para aplicarlos
        Salida: Tabla con registros 

        Descripción: Esta función se encarga de realizar la consulta a la base de datos de acuerdo a 
        la sección(comentarios o mantenimientos) y a los parámetros. 

        Los parámetros para los comentarios son el servicio y la calificación de los comentarios; para los
        matenimientos son el rango de fechas.
    */
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

    /*
        Nombre de la función: generarTablaComentarios
        Entrada: Resultado de la consulta, la sección, los parámetros y el id del administrador
        Salida: Tabla con los comentarios

        Descripción: La función permite mostrar una gráfica de pastel con el resultado, mostrar 
        comentarios de acuerdo a los parámetros de los filtros y un botón para generar el pdf.
    */
    function generarTablaComentarios($resultado, $parametro1, $parametro2, $idAdmin, $seccion){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        
    ?>
        <!--Este script permite realizar la gráfica de pastel, de acuerdo a los comentarios positivos 
        y negativos del servicio que el usuario eligió.
    
        Para la gráfica se utilizó Google Charts en el que nos permité crearla y despues convertirla en
        imagen-->
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

                //Se crea la imagen de la gráfica
                document.getElementById('variableReporte').value = chart.getImageURI();
            }
        </script>

        <!--Este formulario esta conformado por inputs de tipo hidden por lo que no se mostrarán al usuario,
        pero estos se encargarán de enviar información que se obtuvi anteriormente para así generar el pdf-->
        <form method="post" action="reporteComentarios.php" target='_blank' class="col-11">
            <!--Botón para generar el pdf-->
            <button type="submit" class="btn btn-danger btnPDF"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>
            <!--Variable para generar la imagen de la gráfica-->
            <input type="hidden" name="variableReporte" id="variableReporte">
            <!--Parámetro 1-->
            <input type="hidden" name="servicio" id="servicio" value="<?php echo $parametro1;?>">
            <!--Parámetro 2-->
            <input type="hidden" name="filtro" id="filtro" value="<?php echo $parametro2;?>" >
            <!--Sección a la cuál se le aplica el filtro-->
            <input type="hidden" name="seccion" id="seccion"  value="<?php echo $seccion;?>">
            <!--Id del administrador-->
            <input type="hidden" name="idAdmin" id="idAdmin" value="<?php echo $idAdmin;?>">
            <br>
            <br>
            <br>
            <!--Titulo de la gráfica-->
            <h3>Gráfica de comentarios</h3>
            <!--Div dondé se colocará el gráfico-->
            <div id="grafico"></div>
        </form>
    <?php

        //Posteriormente a la gráfica se muestran 
        echo '<h3>Comentarios</h3>';

        echo '<div class="table-responsive">';
        echo "<table class='table table-striped table-hover'>";
        //Se muestra los nombres de cada columna de la tabla
        echo "<thead>";
        echo "<th>Servicio</th>";
        echo "<th>Calificacion</th>";
        echo "<th>Comentario</th>";
        echo "</thead>"; 
        //Se muestran los datos encontrados de la búsqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>"; //Servicio
           
            echo "<td> <span>"; 

            //Se crean las estrellas de acuerdo a la calificación
            for($estrellas = 0; $estrellas < $row[2];$estrellas++){
                echo "<i class='fa-solid fa-star' style='color:#FFD607;' ></i> ";
            }
            
            echo $row[2]; echo " Estrella(s)</span></td>"; 
            echo "<td>"; echo $row[1]; echo "</td>"; //Comentario
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';      
    }

    /*
        Nombre de la función: contarComentarios
        Entrada: id del servicio
        Salida: Array con el conteo de los comentarios positivos y negativos.

        Descripción: Esta función crea un array con el total de comentarios positivos
        y negativos de acuerdo al servicio indicado.
    */
    function contarComentarios($servicio){
      
        $resComentariosPositivos = contarComentariosPositivos($servicio);
        $resComentariosNegativos = contarComentariosNegativos($servicio);

        //Se verifica que el resultado retornado no tenga errores de consulta
        if (!$resComentariosPositivos && !$resComentariosNegativos){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            //Se crea el array
            $conteo = [
                0 => "".$resComentariosPositivos,
                1 => "".$resComentariosNegativos,
            ];
            return $conteo; //Se retorna el array
        }
    }

    /*
        Nombre de la función: generarTablaMantenimientos
        Entrada: Resultado de la consulta, la fecha de inicio y la fecha de termino de las tareas.
        Salida: Tabla con las tareas de los mantenimientos

        Descripción: La función permite mostrar la gráfica de pastel con los resultados de las tareas,
        la tabla con los resultados de las tareas de los mantenimientos, el registro del mejor empleado
        y el botón para generar el pdf.
    */
    function generarTablaMantenimientos($resultado, $fechaInicio, $fechaTermino){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php'; 
        
    ?>
        <!--Este script permite realizar la gráfica de pastel, de acuerdo a los comentarios positivos 
        y negativos del servicio que el usuario eligió.
    
        Para la gráfica se utilizó Google Charts en el que nos permité crearla y despues convertirla en
        imagen-->
        <script>
            google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                    //Datos con los que se crea la gráfica
                    var data = google.visualization.arrayToDataTable([
                    ['Puntuacion', '%'],
                    <?php 
                       $contarTareas = contarTareasXEstatus($fechaInicio, $fechaTermino);
                    
                       echo "['Pendientes', ".$contarTareas[0]."],";
                       echo "['En proceso', ".$contarTareas[1]."],";
                       echo "['Finalizadas', ".$contarTareas[2]."],";
                    ?>
                
                    ]);

                    //Visualizar la gráfica en 3D
                    var options = { is3D: true,};

                    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
                    chart.draw(data, options);

                    //Se crea una imagen de la gráfica
                    document.getElementById('variableReporte').value = chart.getImageURI();
                }
        
        </script>

        <!--Este formulario esta conformado por inputs de tipo hidden por lo que no se mostrarán al usuario,
        pero estos se encargarán de enviar información que se obtuvi anteriormente para así generar el pdf-->
        <form method="post" action="reporteMantenimientos.php" target='_blank' class="col-11">

            <!--Botón que genera el pdf-->
            <button type="submit" class="btn btn-danger btnPDF"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>

            <!--Input que envia la variable de la imagen del reporte-->
            <input type="hidden" name="variableReporte" id="variableReporte">
            <!--Input con la fecha de inicio-->
            <input type="hidden" name="fechaInicio" id="fechaInicio" value="<?php echo $fechaInicio;?>">
            <!--Input con la fecha de término-->
            <input type="hidden" name="fechaTermino" id="fechaTermino" value="<?php echo $fechaTermino;?>" >
            <br>
            <br>
            <br>
            <h3>Gráfica de mantenimientos</h3>
            <!--Gráfica de pastel-->
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


        //Se obtiene el mejor empleado, esté es el que haya realizado mas tareas en el rango de fechas indicado por el usuario
        $resultadoMejorTrabajador = mejorEmpleado($fechaInicio, $fechaTermino);

        //Se verifica que no existan errores en la consulta
        if (!$resultadoMejorTrabajador){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{

            //Se muestran los datos del mejor empleado
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
    }

    /*
        Nombre de la función: contarTareasXEstatus
        Entrada: fecha de inicio y fecha de termino
        Salida: Array con el conteo de los estatus de las tareas

        Descripción: Esta función permite crear un array con el total de tareas de acuerdo al 
        estatus.
    */
    function contarTareasXEstatus($fechaInicio, $fechaTermino){
      
        //Se realiza el conteo con los registros que se tienen en la base de datos
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


    /*
        Nombre de la función: mostrarResultadosGuia
        Entrada: id de la guia y rango de fechas de las visitas guiadas

        Descripción: Esta función realiza la consulta a la base de datos para obtener 
        las visitas guiadas.
    */
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



    /*
        Nombre de la función: generarTablaVisitas
        Entrada: Resultado de la consulta, la fecha de inicio, la fecha de termino de las visitas y el id del guia
        Salida: Tabla con las visitas y la gráfica

        Descripción: La función permite mostrar la gráfica de pastel con los resultados de las visitas,
        la tabla con los resultados de las tareas de los mantenimientos, el registro del mejor empleado
        y el botón para generar el pdf.
    */
    function generarTablaVisitas($resultado, $fechaInicio, $fechaTermino, $idGuia){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php'; 
        
    ?>
        <!--Este script permite realizar la gráfica de pastel, de acuerdo a los comentarios positivos 
        y negativos del servicio que el usuario eligió.
    
        Para la gráfica se utilizó Google Charts en el que nos permité crearla y despues convertirla en
        imagen-->
        <script>
            google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                    //Datos con los que se crea la gráfica
                    var data = google.visualization.arrayToDataTable([
                    ['Puntuacion', '%'],
                    <?php 
                       $contarVisitas = contarVisitasXEstatus($idGuia, $fechaInicio, $fechaTermino);
                    
                       echo "['Pendientes', ".$contarVisitas[0]."],";
                       echo "['En espera', ".$contarVisitas[1]."],";
                       echo "['Finalizadas', ".$contarVisitas[2]."],";
                    ?>
                
                    ]);
                    
                    //Visualizar la gráfica en 3D
                    var options = { is3D: true,};

                    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
                    chart.draw(data, options);

                    //Se crea una imagen de la gráfica
                    document.getElementById('variableReporte').value=chart.getImageURI();
                }
        
        </script>
        <!--Este formulario esta conformado por inputs de tipo hidden por lo que no se mostrarán al usuario,
        pero estos se encargarán de enviar información que se obtuvi anteriormente para así generar el pdf-->
        <form method="post" action="reportevisitas.php" target='_blank' class="col-11">
            <!--Botón que genera el pdf-->
            <button type="submit" class="btn btn-danger btnPDF"> <i class="fa-solid fa-file-pdf"></i> Generar PDF</button>
            <!--Variable que se utiliza para mostrar la imagen de la gráfica-->
            <input type="hidden" name="variableReporte" id="variableReporte">
            <!--Fecha de inicio-->
            <input type="hidden" name="fechaInicio" id="fechaInicio" value="<?php echo $fechaInicio;?>">
            <!--Fecha de termino-->
            <input type="hidden" name="fechaTermino" id="fechaTermino" value="<?php echo $fechaTermino;?>" >
            <!--Id del guía-->
            <input type="hidden" name="idGuia" id="idGuia" value="<?php echo $idGuia;?>" >
            <br>
            <br>
            <br>
            <h3>Gráfica de visitas guiadas</h3>
            <!--Gráfica de pastel-->
            <div id="grafico"></div>
        </form>

    <?php
        //Se muestran los datos obtenidos
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
        //Se muestran los datos encontrados de la búsqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<tr>";
            echo "<td>"; echo $row[0]; echo "</td>";  //Fecha de la visita
            echo "<td>"; echo $row[1]; echo "</td>";  //Estado de la visita
            echo "<td>"; echo $row[2]." ".$row[3]." ".$row[4]; echo "</td>";  //Nombre completo de la visita
            echo "<td>"; echo $row[5]; echo "</td>"; //Correo del visitante
            echo "</tr>";   
        }
        echo "</table>"; 
        echo '</div>';  
    }

    /*
        Nombre de la función: contarVisitasXEstatus
        Entrada: id del guia, fecha de inicio y fecha de termino
        Salida: Array con el conteo de las visitas guiadas por estatus

        Descripción: Esta función realiza consultas a la base de datos para obtener el conteo 
        de las visitas guiadas por estatus de acuerdo a el rango de fechas y apartir de esto 
        se crea un array.
    */
    function contarVisitasXEstatus($idGuia, $fechaInicio, $fechaTermino){
        //Consultas a la base de datos para realizar el conteo de las visitas de acuerdo al estatus
        $resVisitasPendientes = contarVisitas("Pendiente", $fechaInicio, $fechaTermino, $idGuia);
        $resVisitasEnEspera = contarVisitas("En espera", $fechaInicio, $fechaTermino, $idGuia);
        $resVisitasFinalizadas = contarVisitas("Finalizada", $fechaInicio, $fechaTermino, $idGuia);

        //Se verifica si existen errores en las consultas
        if (!$resVisitasEnEspera && !$resVisitasPendientes && !$resVisitasFinalizadas){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "Hola";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            //Se crea el array con los datos
            $conteo = [
                0 => "".$resVisitasPendientes,
                1 => "".$resVisitasEnEspera,
                2 => "".$resVisitasFinalizadas,
            ];
            return $conteo; //Se retorna el array
        }
    }

    /*
        Nombre de la función: contarTodasVisitasGuiadas
        Entrada: id del guía, fecha de inicio y fecha de termino
        Salida: Mensaje de acuerdo a lo de la consulta

        Descripción: Está función realiza un conteo total de las visitas guiadas sin importar 
        el estatus de cada una, para así mostrar un mensaje al usuario con dichos datos.
    */
    function contarTodasVisitasGuiadas($idGuia, $fechaInicio, $fechaTermino){
      
        //Se realiza la consulta a la base de datos 
        $resVisitas = contarTodasVisitas($fechaInicio, $fechaTermino, $idGuia);
   
        //Se verifica si existen errores en la consulta
        if (!$resVisitas){
            //Si existen se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            //Se muestra un span con los datos que se obtuvieron
            echo "<span>El total de visitas guiadas son <b>".$resVisitas. "</b> en un periodo de <b>".$fechaInicio. "</b> a <b>".$fechaTermino."</b>.</span>";
        }
    }
?>