<?php

    header('Content-Type: application/json');
    $pdo = new PDO("mysql:dbname=parquetexcal;host=localhost","root","");
    //Seleccionar los eventos del calendario
    $sentenciaSQL = $pdo->prepare("SELECT * FROM Evento");
    $sentenciaSQL->execute();

    $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultado);
?>
