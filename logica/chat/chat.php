<?php
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/chat/funcionesChat.php';

    function mostrarDatosVisitante($idVisita,$tipoUsuario){

        $resultado = usuarioDestino($idVisita,$tipoUsuario);

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

            if($numfilas > 0){
                while ($datos = mysqli_fetch_row($resultado)){
                    echo "<span style='margin-left:10px;'>"; echo "".$datos[0]." ".$datos[1]; echo "</span>";
                }
            }
        }
        

    }


    function mostrarMensajes($idVisita, $tipoUsuario){

        $nombreUsuario =  nombreUsuarioChat($idVisita,$tipoUsuario);
        $usuarios = array();
        $nombres = array();
        $resultado = consultarMensajes($idVisita);
        if (mysqli_num_rows($resultado) > 0) {
            while ($row = mysqli_fetch_assoc($resultado)){ 
           
                if($nombreUsuario === $row['nombre']){
            ?>
                    <div class="messageUsuario1">
                        <p>
                            <?php echo $row['mensaje']; ?>
                        </p>
                    </div>
            <?php
                }else{
                ?>
                    <div class="messageUsuario2">
                        <p>
                            <?php echo $row['mensaje']; ?>
                        </p>
                    </div>
                <?php
                }
            }
        } else {
            ?>
            <div class="message">
                <p>
                    No hay ninguna conversación previa.
                </p>
            </div>
            <?php
        }
        
    }

?>