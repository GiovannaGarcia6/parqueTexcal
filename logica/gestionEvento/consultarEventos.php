<?php
    header('Content-Type: application/json');
    //Se realiza la conexión a la base de datos
    $pdo = new PDO("mysql:dbname=parquetexcal;host=localhost","root","");
    //Seleccionar los eventos del calendario
    $sentenciaSQL = $pdo->prepare("SELECT * FROM Evento");
    $sentenciaSQL->execute();

    //El resultado es almacenado
    $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    //Se muestra el resultado
    echo json_encode($resultado);
?>
