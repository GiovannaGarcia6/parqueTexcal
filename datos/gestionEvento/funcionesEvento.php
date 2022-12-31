<?php
    function agregarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $InsertaNuevoEvento = "INSERT INTO evento(
            idEvento, 
            nombreEvento,
            descripcionEvento,
            colorEvento,
            textColor,
            fechaInicio,
            fechaFin
            )
          VALUES (
            0,
            '" .$evento. "',
            '" .$descripcion. "',
            '" .$color_evento. "',
            '#FFFFFF',
            '". $fechaI."',
            '" .$fechaF. "'
        )";

        if($conn->query($InsertaNuevoEvento) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión

    }


    function editarEvento($evento, $descripcion, $color_evento, $fechaI, $fechaF,$idEvento){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $actualizarEvento = ("UPDATE evento 
        SET nombreEvento ='$evento',
            fechaInicio ='$fechaI',
            fechaFin ='$fechaF',
            colorEvento ='$color_evento',
            descripcionEvento ='$descripcion'
        WHERE idEvento='".$idEvento."'");

        if($conn->query($actualizarEvento) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión

    }


    function eliminarEvento($idEvento){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        $query = ("DELETE FROM evento WHERE idEvento ='" .$idEvento. "'");

        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }

        mysqli_close($conn);//Se cierra la conexión

    }
?>