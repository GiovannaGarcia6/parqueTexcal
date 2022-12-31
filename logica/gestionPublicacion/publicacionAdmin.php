<?php
    function mostrarPublicaciones($buscador,$idAdmin){
        //Se utiliza require en caso de error para detener el script.
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
                generarDivPublicaciones($resultado,$idAdmin);                   
            }
        }
        
    }

    function generarDivPublicaciones($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se muestran los datos encontrados de la busqueda
        while ($row = mysqli_fetch_row($resultado)){
            echo "<div class='col-12 card tarjeta'>";
            echo "<div class='row'>";
            echo "<div class='col-12 col-sm-6'>";
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
                //Se crea un enlace con un botón para editar, el cual redirige al formulario con el id de la tarifa(idBoleto)
                echo "<center> <a href='/sistema Web/presentacion/administrador/publicaciones/editarPublicacion.php?idPublicacion=".$row[0]."&id=".$id."'> <button type='button' class='btn col-lg-3 col-md-3 col-sm-4 btn-primary'> Actualizar <i class='fa-solid fa-pencil'></i></button></a>     ";
                //Se crea un un botón para eliminar, el cual con boostrap  se abre un modal enviando en data-bs-id el id de la tarifa
                echo "<button type='button' class='btn btn-danger col-lg-3 col-md-3 col-sm-4' data-bs-idAdmin='".$id."' data-bs-idPublicacion='".$row[0]."'  data-bs-toggle='modal' data-bs-target='#modalEliminar'>Eliminar <i class='fa-solid fa-trash-can'></i></button></center>";                                              
                echo "</div>";
                echo "</div>";
                echo "</div>";  
                echo "<br>";                     
        }
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function mostrarServicio($seleccionado,$idServicio){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        $resultado=servicios();
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
        
        mysqli_close($conn); //Se cierra la conexión con la bd.
    }


?>
       