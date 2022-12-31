<?php
    function mostrarCarpetas($buscador,$id){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

        $resultado = buscadorCarpetas($buscador);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay carpetas.</div><br>';  
            }else{
                generarCarpetas($resultado,$id);                   
            }
        }
        
    }

    function generarCarpetas($resultado,$id){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo "<div class='row'>";
        while ($row = mysqli_fetch_row($resultado)){
           ?>
            <div class="card carpet border-warning col-11 col-sm-5 col-md-2">
                <a id="abrirCarpeta" href="../archivos/archivos.php?id=<?php echo $id;?>&idExp=<?php echo  $row[0]; ?>" class="card-header border-warning">
                    <center>
                        <i class="fa-solid fa-folder-open" style="color:#fff; font-size:60px"></i><br>
                        <h5 class="card-title"><?php echo $row[1];?></h5>
                    </center>
                </a>

                    <a href="#" data-bs-idAdmin='<?php echo $id?>' data-bs-idExp='<?php echo $row[0];?>' data-bs-toggle='modal' data-bs-target='#modalEliminar' class="acciones card-footer border-warning"><center><i class="fa-solid fa-trash"></i> Eliminar</center></a>
                    <a href="editarCarpeta.php?idAdmin=<?php echo $id;?>&id=<?php echo $row[0];?>" class="acciones card-footer border-warning"><center><i class="fa-solid fa-pencil"></i> Editar</center></a>
               
            </div>    
           <?php                   
        } 
        echo "</div>";              
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }


    function mostrarArchivos($buscador, $idCarpeta, $idAdmin){
        //Se utiliza require en caso de error para detener el script.
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/gestionArchivero/funcionesArchivero.php';

        $resultado = buscadorArchivos($buscador,$idCarpeta);             
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
                echo '<div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert"  style="margin-top:10px;">No hay archivos.</div><br>';  
            }else{
                generarArchivos($resultado,$idAdmin);                   
            }
        }
        
    }

    function generarArchivos($resultado,$idAdmin){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        echo "<div class='row'>";
        while ($row = mysqli_fetch_row($resultado)){
           ?>
            <div class="card archivo border-danger col-11 col-sm-5 col-md-2">
                <a id="abrirArchivo" href="../../../archivosTemp/<?php echo $row[2]; ?>" class="archivo-header card-header border-danger">
                    <center>
                        <i class="fa-solid fa-file-pdf" style="color:#fff; font-size:60px; margin-bottom:8px;"></i><br>
                        <h5 class="card-title"><?php echo $row[1];?></h5>
                    </center>
                </a>
                <a href="#" data-bs-idAdmin='<?php echo $idAdmin?>' data-bs-idArc='<?php echo $row[0];?>' data-bs-toggle='modal' data-bs-target='#modalEliminar' class="accionesArch card-footer border-danger"><center><i class="fa-solid fa-trash"></i> Eliminar</center></a>

            </div> 

           <?php                   
        } 
        echo "</div>";         
        
        mysqli_close($conn);//Se cierra la conexión con la bd.     
    }

?>