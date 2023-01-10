<?php
    //Archivo que nos permite acceder a las funciones del chat
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/chat/funcionesChat.php';

    /*
        Nombre de la función: mostrarDatosVisitante
        Entrada: Id de la visita y el tipo de usuario
        
        Descripción: La función permite mostrar los datos del usuario, los cuales son obtenidos con la función usuarioDestino
        que retornará dichos datos para que sean mostrados en la interfaz.
    */
    function mostrarDatosVisitante($idVisita,$tipoUsuario){

        //En la variable rsultado se almacenan los datos del usuario al que se le va a enviar los mensajes
        $resultado = usuarioDestino($idVisita,$tipoUsuario);

        //Si el resultado es erroneo se mandará un mensaje al usuario.
        if (!$resultado){
            //Se manda un mensaje con el error que ocurrió en la consulta.
            echo "<br>";
            echo "La consulta SQL contiene errores.";
            exit();
        }else{
            //Se obtiene el número de filas que tuvo el resultado del query.
            $numfilas = $resultado->num_rows;

            //Si es mayor a 0 indica que existe el registro del cual se obtienen los datos
            if($numfilas > 0){

                //Los datos se agregan en un elemento span
                while ($datos = mysqli_fetch_row($resultado)){
                    echo "<span style='margin-left:10px;'>"; echo "".$datos[0]." ".$datos[1]; echo "</span>";
                }
            }
        }
    }

    /*
        Nombre de la función: mostrarMensajes
        Entrada: Id de la visita y el tipo de usuario
        
        Descripción: La función permite mostrar los mensajes que tiene el chat.
    */
    function mostrarMensajes($idVisita, $tipoUsuario){

        //Se obtiene el nombre del usuario que envio los mensajes
        $nombreUsuario =  nombreUsuarioChat($idVisita,$tipoUsuario);

        //Se llama la función consultar mensajes, la cual retornará los mensajes que existen en la tabla cuyo id de la visita
        //sea igual al que se obtuvo
        $resultado = consultarMensajes($idVisita);

        //Se verifica que el resultado que se retorno tenga filas mayores a 0
        if (mysqli_num_rows($resultado) > 0) {

            //Se realiza un ciclo para mostrar todoso los mensajes
            while ($row = mysqli_fetch_assoc($resultado)){ 
                
                //Se verifica que el nombre que se obtuvo con la función sea igual al que envío el mensaje
                if($nombreUsuario === $row['nombre']){

                    //Si es igual, se crea el elemento para mostrar el mensaje del lado derecho
            ?>
                    <div class="messageUsuario1">
                        <p>
                            <?php echo $row['mensaje']; ?>
                        </p>
                    </div>
            <?php
                }else{
                    //Sino, se crea el elemento para mostrar el mensaje del lado izquierdo
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
            //Sino existen mensajes, se crea un elemento para mostrar el mensaje de que no existe una conversación previa
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