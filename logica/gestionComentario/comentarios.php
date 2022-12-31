<?php
    function mostrarComentarios($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';


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

    function generarComentarios($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        while ($row = mysqli_fetch_row($resultado)){
                                    
            echo "<div class='col-12 card tarjeta'>";

            echo "<p> <b> Servicio: </b>"; echo $row[3]; echo "</p>"; 
            echo "<span> <b> Calificación: </b>";
            for($estrellas=0; $estrellas<$row[2];$estrellas++){
                echo "<i class='fa-solid fa-star' style='color:#FFD607;' ></i> ";
            }
            echo $row[2]; echo " Estrellas</span>"; 
            echo "<br>";
            echo "<p> <b> Comentario: </b>"; echo $row[1]; echo "</p>"; 
            
            //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
            echo "<center> <a href='/sistema Web/presentacion/visitante/comentario/editarComentario.php?idComentario=".$row[0]."'> <button type='button' class='btn col-lg-3 col-md-3 col-sm-4 btn-primary'> Actualizar <i class='fa-solid fa-pencil'></i></button></a>     ";
            //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
            echo "<button type='button' class='btn btn-danger col-lg-3 col-md-3 col-sm-4' data-bs-id='".$id."' data-bs-idComentario='".$row[0]."' data-bs-toggle='modal' data-bs-target='#modalEliminar'>Eliminar <i class='fa-solid fa-trash-can'></i></button></center>";
            echo "</div>";  
            echo "<br>";                     
        }
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function mostrarServicios($seleccionado, $idServicio){
      
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        $resultado=servicios();
        if($seleccionado === TRUE){

            while ($servicio = mysqli_fetch_assoc($resultado)) {
                if($servicio['nombServ'] != 'Parque'){
                    echo "<option value='".$servicio['idServicio']."'";
                    //Si es el mismo id que se obtuvo al inicio se muestra como seleccionada.
                    if($servicio['idServicio']==$idServicio){
                        echo ' selected="selected"';
                    }
                    echo ">".$servicio['nombServ']."</option>";
                }
            }
        }else{
            while ($servicio = mysqli_fetch_assoc($resultado)) {
                if($servicio['nombServ'] != 'Parque'){
                    echo '<option value="'.$servicio['idServicio'].'">'.$servicio['nombServ'].'</option>';
                }
            }
        }
        
        mysqli_close($conn); //Se cierra la conexión con la bd.

    }

    function mostrarComentariosAdmin($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';


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

    function generarComentariosAdmin($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo "<div class='row'>";
        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
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
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function mostrarComentariosXServicio($servicio){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionComentario/funcionesComentario.php';


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

    function generarComentariosXServicio($resultado){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        while ($row = mysqli_fetch_row($resultado)){

            $r = mt_rand( 128, 255 );
            $g = mt_rand( 128, 255 );
            $b = mt_rand( 128, 255 );
         
            $bgcolor = 'rgba('.$r.','.$g.','.$b.')';

            echo "<div class='col-12 col-sm-12 col-md-5 card comentario'>";
            $nombre = strtoupper($row[2]);
            echo "<div class='row'>";
            echo "<div class='col-auto'>";
            echo "<div id='circulo' style='background:".$bgcolor.";' ><b>".$nombre[0]."</b></div>";
            echo "</div>"; 
            echo "<div class='col-10'>";
            echo "<span><b>".$row[2]." ".$row[3]."</b>       ";
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
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

?>