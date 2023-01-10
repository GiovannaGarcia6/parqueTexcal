<?php

    /*  
        Nombre de la función: agregarEvento
        Entrada: Evento, descripción, color del evento, fecha de inicio y fecha de termino.
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de un nuevo trabajador con los datos enviados por el usuario.
    */
    function agregarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $InsertarNuevoEvento = "INSERT INTO evento(
            idEvento, 
            nombreEvento,
            descripcionEvento,
            colorEvento,
            textColor,
            fechaInicio,
            fechaFin
            )
            VALUES 
            (0,
            '" .$evento. "',
            '" .$descripcion. "',
            '" .$color_evento. "',
            '#FFFFFF',
            '". $fechaI."',
            '" .$fechaF. "'
        )";

        //Se ejecuta el query
        if($conn->query($InsertarNuevoEvento) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: editarEvento
        Entrada: Id del eventon, el nombre del evento, descripción, color del evento, fecha de inicio y fecha de termino.
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la información del evento con los datos enviados por el usuario.
    */
    function editarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF,$idEvento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        
        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $actualizarEvento = ("UPDATE evento 
        SET nombreEvento ='$evento',
            fechaInicio ='$fechaI',
            fechaFin ='$fechaF',
            colorEvento ='$color_evento',
            descripcionEvento ='$descripcion'
        WHERE idEvento='".$idEvento."'");

        //Se ejecuta el query
        if($conn->query($actualizarEvento) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: eliminarEvento
        Entrada: Id del evento
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un evento indicado por el usuario.
    */
    function eliminarEvento($idEvento){
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza la eliminación del evento que se indico con el id.
        $eliminarEvento = ("DELETE FROM evento WHERE idEvento ='" .$idEvento. "'");

        //Se ejecuta el query
        if($conn->query($eliminarEvento) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }

        mysqli_close($conn);//Se cierra la conexión

    }
?>