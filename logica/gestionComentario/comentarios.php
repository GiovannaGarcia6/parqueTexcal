<?php

    /*
        Nombre de la función: mostrarComentarios
        Entrada: Frase o palabra a buscar, id del visitante

        Descripción: La función permite realizar la búsqueda de comentarios que coincidan con
        lo que se envío del buscador y con el id del visitante para posteriormente, realizar 
        una verificación de los resultados retornados. Si el resultado tiene errores se debe mandar 
        un mensaje al usuario, sino contiene ningún error se verifica si existen filas, los cuales
        son los registros. Si el número de filas es igual a 0 indica que no hay registros y que 
        se debe mostrar un mensaje al usuario, en caso de que si existan resultados se realiza la
        llamada a la función correspondiente para generar mostrar los datos.
    */
    function mostrarComentarios($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';

        //Se llama a la función para obtener los registros que coincidan con lo almacenado en el buscador y con el id del visitante.
        $resultado = buscadorComentarios($buscador,$id);  

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
                generarComentarios($resultado,$id);                   
            }
        }
    }

    /*
        Nombre de la función: generarComentarios
        Entrada: Resultado de la consulta y id del visitante
        Salida: Contenedor con los datos del comentario

        Descripción: La función permite mostrar un contenedor con los registros que se obtuvieron de
        la consulta.
    */
    function generarComentarios($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        while ($row = mysqli_fetch_row($resultado)){
                                    
            echo "<div class='col-12 card tarjeta'>";

            echo "<p> <b> Servicio: </b>"; echo $row[3]; echo "</p>"; 
            echo "<span> <b> Calificación: </b>";
            //Se realiza un for para crear los iconos de las estrellas
            for($estrellas=0; $estrellas<$row[2];$estrellas++){
                echo "<i class='fa-solid fa-star' style='color:#FFD607;' ></i> ";
            }
            echo $row[2]; echo " Estrellas</span>"; 
            echo "<br>";
            echo "<p> <b> Comentario: </b>"; echo $row[1]; echo "</p>"; 
            
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id del comentario
            echo "<center> <a href='/sistema Web/presentacion/visitante/comentario/editarComentario.php?idComentario=".$row[0]."'> <button type='button' class='btn col-lg-3 col-md-3 col-sm-4 btn-primary'> Actualizar <i class='fa-solid fa-pencil'></i></button></a>     ";
            //Se crea un un botón para eliminar, el cual con boostrap se abre un modal enviando en data-bs-idComentario el id del comentario
            echo "<button type='button' class='btn btn-danger col-lg-3 col-md-3 col-sm-4' data-bs-id='".$id."' data-bs-idComentario='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'>Eliminar <i class='fa-solid fa-trash-can'></i></button></center>";
            echo "</div>";  
            echo "<br>";                     
        }
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

    /*
        Nombre de la función: mostrarServicios
        Entrada: un booleano y el id del servicio
        Salida: Elementos option con los servicios

        Descripción: La función permite generar elementos option, cada option generado es un servicio del parque.
    */
    function mostrarServicios($seleccionado, $idServicio){
        
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        //Se obtienen todos los servicios almacenados de la base de datos
        $resultado = servicios();

        /*De acuerdo a lo que contenga la variable $seleccionado se verificará para realizar los 
        option correspondientes*/
        if($seleccionado === TRUE){
            //Se realiza un ciclo, en el que se recorre cada registro del array
            while ($servicio = mysqli_fetch_assoc($resultado)) {
                //En este caso, el if ayuda a realizar solo la lista de servicios que no sea el parque
                if($servicio['nombServ'] != 'Parque'){
                    //Se crea el option del servicio
                    echo "<option value='".$servicio['idServicio']."'";
                    //Si es el mismo id que se obtuvo al inicio se muestra como seleccionada.
                    if($servicio['idServicio'] === $idServicio){
                        echo ' selected="selected"';
                    }
                    echo ">".$servicio['nombServ']."</option>";
                }
            }
        }else{
            //En este caso, se realiza lo mismo que el anterior solo que se omite el option que este seleccionado
            while ($servicio = mysqli_fetch_assoc($resultado)) {
                if($servicio['nombServ'] != 'Parque'){
                    echo '<option value="'.$servicio['idServicio'].'">'.$servicio['nombServ'].'</option>';
                }
            }
        }     
    }

    /*
        Nombre de la función: mostrarComentariosAdmin
        Entrada: Frase o palabra a buscar, id del administrador

        Descripción: La función permite realizar la búsqueda de comentarios que coincidan con
        lo que se envío del buscador para posteriormente, realizar una verificación de los resultados
        retornados. Si el resultado tiene errores se debe mandar un mensaje al usuario, sino contiene
        ningún error se verifica si existen filas, los cuales son los registros. Si el número de
        filas es igual a 0 indica que no hay registros y que se debe mostrar un mensaje al usuario, 
        en caso de que si existan resultados se realiza la llamada a la función correspondiente para
        generar mostrar los datos.
    */
    function mostrarComentariosAdmin($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';

        //Se realiza la llamada a la función para obtener los comentarios con esa frase o palabra almacenada en la variable buscador
        $resultado = buscadorComentariosAdmin($buscador);  

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
                    generarComentariosAdmin($resultado,$id);                   
                }
            }
        
    }

    /*
        Nombre de la función: generarComentariosAdmin
        Entrada: Resultado de la consulta y id del administrador
        Salida: Contenedor con los datos del comentario

        Descripción: La función permite mostrar un contenedor por cada comentario que devuelva.
    */
    function generarComentariosAdmin($resultado,$id){

        echo "<div class='row'>";
        //Se muestran los datos encontrados de los comentarios 
        while ($row = mysqli_fetch_row($resultado)){
            //se crea el contenedor con los datos del comentario, es decir, el nombre del visitante, el comentario y las estresllas
?>
            <div class="col-12 col-md-4 card cardComentario text-center">
                <div class="card-header">
                    <div class="row rowComentario">
                        <div class="col-7 col-sm-9 col-md-8" style="padding:0;text-align: center; vertical-align: middle;">
                            <p><b> Visitante: </b> <?php echo $row[4]; echo " ".$row[5];?></p>
                        </div>

                        <div class="col-5 col-sm-3 col-md-4" style="padding:0; margin:0;">
                            <button type='button' style="text-align:center;" class='btn btn-danger col-6 col-md-10' data-bs-id='<?php echo $id;?>' data-bs-idComentario='<?php echo $row[0];?>' data-bs-toggle='modal' data-bs-target='#modalEliminar'><i class='fa-solid fa-trash'></i></button>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row[3];?></h5>
                    <p class="card-text"><?php  echo $row[1]; ?></p>
                </div>
                <div class="card-footer text-muted">
                    <?php 
                        echo "<span> <b> Calificación: </b>";
                        for($estrellas=0; $estrellas<$row[2];$estrellas++){
                            echo "<i class='fa-solid fa-star' style='color:#FFD607;' ></i> ";
                        }
                        echo $row[2]; echo " Estrellas</span>"; 
                    ?>
                </div>
            </div> 
<?php             
        }
        echo "</div>";           
    }

    /*
        Nombre de la función: mostrarComentariosXServicio
        Entrada: id del servicio

        Descripción: La función permite realizar la búsqueda de comentarios de un servicio en especifico,
        posteriormente, se realiza una verificación de los resultados retornados. Si el resultado tiene 
        errores se debe mandar un mensaje al usuario, sino contiene ningún error se verifica si existen filas,
        los cuales son los registros. Si el número de filas es igual a 0 indica que no hay registros y que 
        se debe mostrar un mensaje al usuario, en caso de que si existan resultados se realiza la
        llamada a la función correspondiente para generar mostrar los datos.
    */
    function mostrarComentariosXServicio($servicio){

        //Se utiliza require en caso de error para detener el script. El archivo contiene funciones que permiten realizar la consulta a la base de datos.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';

        //Se hace el llamado a la función para realizar una consulta de los comentarios por servicio
        $resultado = buscadorComentariosXServicio($servicio);  

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
                    echo '<div id="alerta" class="alert alert-warning d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay comentarios.</div><br>';  
                }else{
                    generarComentariosXServicio($resultado);                   
                }
            }
        
    }

    /*
        Nombre de la función: generarComentariosXServicio
        Entrada: Resultado de la consulta
        Salida: Contenedor con los datos del comentario

        Descripción: La función permite mostrar un contenedor por cada comentario que devuelva, estos comentarios 
        serán mostrados en la página del servicio
    */
    function generarComentariosXServicio($resultado){
        //Se crea un ciclo para recorrer cada comentario y así obtener los datos
        while ($row = mysqli_fetch_row($resultado)){
            //Se realiza un aleatorio, para obtener un color en rgb y que este represente el perfil del usuario
            $r = mt_rand( 128, 255 );
            $g = mt_rand( 128, 255 );
            $b = mt_rand( 128, 255 );
         
            //Una vez obteido el aleatorio de cada variable, se almacena en la variable bgcolor
            $bgcolor = 'rgba('.$r.','.$g.','.$b.')';

            echo "<div class='col-12 col-sm-12 col-md-5 card comentario'>";
            $nombre = strtoupper($row[2]);
            echo "<div class='row'>";
            echo "<div class='col-auto'>";
            echo "<div id='circulo' style='background:".$bgcolor.";' ><b>".$nombre[0]."</b></div>";
            echo "</div>"; 
            echo "<div class='col-10'>";
            echo "<span><b>".$row[2]." ".$row[3]."</b>       ";
            //Se crea un for para crear los iconos de las estrellas que indican la calificación del servicio
            for($estrellas=0; $estrellas<$row[1];$estrellas++){
                echo "<i class='fa-solid fa-star' style='color:#FFD607;'></i> ";
            }
            echo "</span>"; 
            echo "</div>"; 
            echo "</div>"; 
            echo "<p class='txtComentario'>"; echo $row[0]; echo "</p>"; 
            echo "</div> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";  
            echo "<br>";          
        }
    }

?>