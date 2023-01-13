<?php
    /*
        Nombre de la función: mostrarPublicacion
        Entrada: Nombre del servicio
        Salida: Contenedores con la info de las publicaciones

        Descripción: Esta función se encarga de mostrar las publicaciones de la página principal que ven todos los usuarios. 
        Estos muestran solo el titulo de la publicación la descripción y el recurso visual.
    */
    function mostrarPublicacion($servicio){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionPublicacion/funcionesPublicacion.php';

        $resultado = consultarPublicaciones($servicio);

        //Se obtiene el número de filas que tuvo el resultado del query.
        $numfilas = $resultado->num_rows;

        //Si el número de filas es 0, se debe mostrar un mensaje de no hay publicaciones.
        if($numfilas==0){   
            echo '<div id="alerta" class="alert alert-warning d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay publicaciones en este momento.</div><br>';
        }else{
            //Se muestran los datos encontrados de la busqueda
            while ($row = mysqli_fetch_row($resultado)){
                                        
                echo "<div class='col-12 card publicacion'>";
                    echo "<div class='row'>";
                        echo "<div class='col-12 col-sm-6 videoImagen'>";
                            if($row[3]==="Video"){
                                ?>
                                    <iframe class="recurso" src="<?php echo $row[4]; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php
                        
                            }else{
                                if($servicio === "Parque"){
                                    echo '<img src="presentacion/'.$row[4].'" class="recurso" >';
                                }else{
                                    echo '<img src="../'.$row[4].'" class="recurso" >';
                                }
                               
                            }
                        echo "</div>";
                        echo "<div class='col-12 col-sm-5 textoPublicacion'>";
                            echo "<p class='tituloPubli'> <b> ".$row[1]." </b></p>"; 
                            echo "<p class='descripPubli'>".$row[2]."</p>"; 
                        echo "</div>";
                    echo "</div>";
                echo "</div>";  
                echo "<br>";   
            }                  
        }

    }
?>