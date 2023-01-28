<?php

    /*
        Nombre de la función:mostrarBoletos
        Entrada: Frase o palabra a buscar, id del administrador

        Descripción: La función permite realizar la búsqueda de boletos que coincidan con
        lo que se envío del buscador para posteriormente, realizar una verificación de los resultados
        retornados. Si el resultado tiene errores se debe mandar un mensaje al usuario, sino contiene
        ningún error se verifica si existen filas, los cuales son los registros. Si el número de
        filas es igual a 0 indica que no hay registros y que se debe mostrar un mensaje al usuario, 
        en caso de que si existan resultados se realiza la llamada a la función correspondiente para
        generar mostrar los datos.
    */
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

    /*
        Nombre de la función: generarTablaBoletos
        Entrada: Resultado de la consulta y id del administrador
        Salida: Tabla de boletos

        Descripción: La función permite mostrar una tabla con los registros que se obtuvieron de
        la consulta.
    */
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

    
    /* 
        Nombre de lla función: mostrarServicio
        Entrada: Nombre del servicio
        Salida: Elementos option de un selector

        Descripción: Está función permite obtener los servicios existentes 
        y así crear un option por cada servicio.
    */
    function mostrarServicio($nombreServicio){

        //Archivos para obtener las funciones y la conexión a la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        //Se obtienen los servicios
        $resultado = servicios();
                 
        //Se realiza un ciclo para crear los option de cada servicio
        while ($servicio = mysqli_fetch_assoc($resultado)) {
            if($servicio['nombServ'] != 'Parque'){
                echo "<option value='".$servicio['idServicio']."'";
                //Si es el mismo nombre del servicio que se obtuvo al inicio se muestra como seleccionada.
                if($nombreServicio === $servicio['nombServ']){
                    echo ' selected="selected"';
                }
                echo ">".$servicio['nombServ']."</option>";
            }
            
        }
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }


    /*
        Nombre de la función: mostrarBoletosServicio
        Entrada: id del servicio

        Descripción: La función permite realizar la búsqueda de boletos que coincidan con
        el id del servicio para posteriormente realizar una verificación de los resultados
        retornados. Si el resultado tiene errores se debe mandar un mensaje al usuario, sino contiene
        ningún error se verifica si existen filas, los cuales son los registros. Si el número de
        filas es igual a 0 indica que no hay registros y que se debe mostrar un mensaje al usuario, 
        en caso de que si existan resultados se realiza la llamada a la función correspondiente para
        generar mostrar los datos.
    */
    function mostrarBoletosServicio($idServicio){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionBoleto/funcionesBoleto.php';

        //Se realiza la obtención de los boletos de un servicio
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

    /*
        Nombre de la función: generarBoletosServicios
        Entrada: Resultado de la consulta 
        Salida: Boletos de un servicio

        Descripción: La función permite mostrar una contenedor con los boletos que se obtuvieron del servicio.
    */
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

