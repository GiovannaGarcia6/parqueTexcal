<?php
    require '../../datos/controlVisitasGuiadas/funcionesVisitasGuiadas.php';

    session_start();//Se inicia la sesión.

    $id = $_GET['id'];
    $idVisita = $_GET['idVisita'];


    $finalizarVisita = finalizarVisita($idVisita);
   
    if($finalizarVisita === 1){
        $correo = obtenerCorreoVisitante($idVisita);
        
        $header = "From: parqtexc@gmail.com \r\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header .= "Content-Type: text/plain";

        $message .= "Su visita guiada fue finalizada. Lo invitamos a dejar su comentario a través de su perfil.\r\n";
        $message .= "Muchas gracias ¡Vuelva pronto!\r\n\n";
        $message .= "- Dirección: Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. CP. 62573 \r\n";

        $asunto = 'Visita Guiada Finalizada';

        
        mail($correo, $asunto, utf8_decode($message), $header);

        $_SESSION['status'] = "Visita finalizada con éxito.";
        header("Location: ../../presentacion/guia/visitaGuiada/visitasPendientes.php?id=".$id);
    }else{
        $_SESSION['status'] = "Hubo un error al aceptar.";
        header("Location: ../../presentacion/guia/visitaGuiada/visitasPendientes.php?id=".$id);
    }
?>