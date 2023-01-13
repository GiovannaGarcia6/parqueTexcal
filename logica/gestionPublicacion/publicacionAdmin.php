<?php
    /*
        Nombre de la función: mostrarPublicacion
        Entrada: buscador(frase o palabra) y id del administrador

        Descripción: Esta función obtiene todos los regstros obtenidos de la base de datos y los manda a 
        la función generarDivPublicaciones. En caso de que lo retornado de la capa de datos indique que no
        existen, la función se encargará de crear un mensaje para mostrarlo en la interfaz.
    */
    function mostrarPublicaciones($buscador,$idAdmin){
        //Se utiliza require en caso de error para detener el script. El archivo contiene mas funciones de las publicaciones
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        $resultado = buscadorPublicaciones($buscador);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay publicaciones.</div><br>';  
            }else{
                //Llamar a la función enviando el resultado de los registros y el id del administrador
                generarDivPublicaciones($resultado,$idAdmin);                   
            }
        }
        
    }
    /*
        Nombre de la función: generarDivPublicaciones
        Entrada: Resultado de los registros y id del administrador
        Salida: Div's con la información de las publicaciones

        Descripción: Esta función se encarga de generar los contenedores necesarios de acuerdo a la cantidad de 
        registros enviados.
    */
    function generarDivPublicaciones($resultado,$id){
        //Se muestran los datos encontrados de la búsqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<div class='col-12 card tarjeta'>";
            echo "<div class='row'>";
            echo "<div class='col-12 col-sm-6'>";
            //Se verifica si es un video o imagen, para que este tenga especificaciones diferentes al mostrar dicho elemento
            if($row[3]==="Video"){
            ?>
                <iframe width="100%" height="300" src="<?php echo $row[4]; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php                                  
            }else{
                echo '<img src="../../'.$row[4].'" width="100%" height="300" >';
            }
            echo "</div>";
            echo "<div class='col-12 col-sm-6'>";
            echo "<p> <b> Servicio: </b>"; echo $row[5]; echo "</p>"; 
            echo "<p> <b> Titulo: </b>"; echo $row[1]; echo "</p>"; 
            echo "<span> <b> Descripción: </b>"; echo $row[2]; echo "</p>"; 
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la publicación y el id del admin
            echo "<center> <a href='/sistema Web/presentacion/administrador/publicaciones/editarPublicacion.php?idPublicacion=".$row[0]."&id=".$id."'> <button type='button' class='btn col-lg-3 col-md-3 col-sm-4 btn-primary'> Actualizar <i class='fa-solid fa-pencil'></i></button></a>     ";
            //Se crea un un botón para eliminar, el cual con boostrap se abre un modal enviando en data-bs-idAdmin el id del admin y en data-bs-idPublicacion el id de la publicación
            echo "<button type='button' class='btn btn-danger col-lg-3 col-md-3 col-sm-4' data-bs-idAdmin='".$id."' data-bs-idPublicacion='".$row[0]."'  data-bs-toggle='modal' data-bs-target='#modalEliminar'>Eliminar <i class='fa-solid fa-trash-can'></i></button></center>";                                              
            echo "</div>";
            echo "</div>";
            echo "</div>";  
            echo "<br>";                     
        }
    }

    /*
        Nombre de la función: mostrarServicio
        Entrada: True o False dependiendo de si se necesita a un servicio seleccionado y un id del servicio
        Salida: Generar los option con los servicios

        Descripción: Esta función permite mostrar los servicios, para generarlos hay dos opciones:
        1. Puede no tener ningún servicio seleccionado, por lo que, la variable seleccionado almacenara un false
        y el idServicio será un 0.
        2. Puede llevar un servicio seleccionado, por lo que, necesitara tener un True y el id del servicio.
    */
    function mostrarServicio($seleccionado,$idServicio){
        //Se utiliza require en caso de error para detener el script. El archivo contiene mas funciones de las publicaciones
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        //Se retornan los datos del servicio
        $resultado = servicios();

        //Se verifica si hay que mostrar un servicio seleccionado
        if($seleccionado === true){
            while ($servicio = mysqli_fetch_assoc($resultado)) {
                echo '<option value="'.$servicio['idServicio'].'">'.$servicio['nombServ'].'</option>';
            }
        }else{                
            while ($servicio = mysqli_fetch_assoc($resultado)) {

                echo "<option value='".$servicio['idServicio']."'";
                //Si es el mismo id que se obtuvo al inicio se muestra como seleccionada.
                if($servicio['idServicio']===$idServicio){
                    echo ' selected="selected"';
                }
                echo ">".$servicio['nombServ']."</option>";
            }
        }
    }
?>
       