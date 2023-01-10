<?php
	/*
	 	Entrada: La función necesita el host, el usuario, la contraseña, el nombre de la base de datos y las tablas a respaldar.
		Salida: Archivo SQL que se descarga desde el navegador en uso.

		Descripción:  La función respaldarBD realiza el script con comentarios y sentencias sql que permiten crear las tablas,
		agregar los registros que se encuentran en cada tabla.
	*/
	function respaldarBD($host, $user, $pass, $dbname, $tables = '*'){
		//Se realiza la conexión de la base de datos
		$conn = new mysqli($host, $user, $pass, $dbname);
		if ($conn->connect_error) {
		    die("La conexión falló: " . $conn->connect_error);
		}
 
		//Se obtienen todas las tablas de las cuales se van a respaldar
		if($tables == '*'){
			$tables = array();
			$sql = "SHOW TABLES";
			$query = $conn->query($sql);
			while($row = $query->fetch_row()){
				$tables[] = $row[0];
			}
		}else{
			/* En caso de que solo se quiera hacer el respaldo de ciertas tablas, estas se almacenan en la variable 
			y cada elemento del array sera aquel que este separado por una coma. */
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
 
		/*Con la variable $outsql se almacenara el script con todas las sentencias que ayudarán a realizar el respaldo, 
		esto inclus¡ye tambieén los comentarios*/
		$outsql = "\n-- Host: $host    Database: $dbname\n-- ------------------------------------------------------\n-- Server version	10.4.27-MariaDB\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n/*!40101 SET NAMES utf8mb4 */;\n/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;\n/*!40103 SET TIME_ZONE='+00:00' */;\n/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;\n/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;\n/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;\n/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;\n";
        
		//Ciclo que nos ayudará a crear la estructura de cada tabla a respaldar, ademas de crear las sentencias sql para crear los registros que tiene cada tabla.
		foreach ($tables as $table) {
    
			$outsql .= "--\n-- Table structure for table `$table`\n--";
			$outsql .= "\n"; 
			$outsql .= "\n"; 
			$outsql .= "DROP TABLE IF EXISTS `$table`;";
			$outsql .= "\n"; 

			$outsql .= "/*!40101 SET @saved_cs_client     = @@character_set_client */;";
			$outsql .= "\n"; 
			$outsql .= "/*!40101 SET character_set_client = utf8 */;";
		    // Se prepara la estructura del archivo ejecutando
		    $sql = "SHOW CREATE TABLE $table";
		    $query = $conn->query($sql);
		    $row = $query->fetch_row();
		    
		    $outsql .= "\n\n" . $row[1] . ";\n\n";
		    
		    $sql = "SELECT * FROM $table";
		    $query = $conn->query($sql);
		    
		    $columnCount = $query->field_count;
 
			$outsql .= "/*!40101 SET character_set_client = @saved_cs_client */;";
			$outsql .= "\n"; 
			$outsql .= "\n"; 

			$outsql .= "--\n-- Dumping data for table `$table`\n--";

		    $outsql .= "\n"; 
			$outsql .= "\n"; 
			$outsql .= "LOCK TABLES `$table` WRITE;";
			$outsql .= "\n"; 
			$outsql .= "/*!40000 ALTER TABLE `$table` DISABLE KEYS */;";
			$outsql .= "\n"; 
			 // Se preparan los datos de cada tabla
			 for ($i = 0; $i < $columnCount; $i ++) {
		        while ($row = $query->fetch_row()) {
		            $outsql .= "INSERT INTO $table VALUES(";
		            for ($j = 0; $j < $columnCount; $j ++) {
		                $row[$j] = $row[$j];
		                
		                if (isset($row[$j])) {
		                    $outsql .= '"' . $row[$j] . '"';
		                } else {
		                    $outsql .= '""';
		                }
		                if ($j < ($columnCount - 1)) {
		                    $outsql .= ',';
		                }
		            }
		            $outsql .= ");\n";
		        }
		    }
			$outsql .= "\n"; 
			$outsql .= "/*!40000 ALTER TABLE `$table` ENABLE KEYS */;";
			$outsql .= "\n"; 
			$outsql .= "UNLOCK TABLES;\n";
			$outsql .= "\n";
		}
 
		// Se guarda el script en un archivo.sql
	    $backupArchivo= $dbname . '_backup_'.time().'.sql';
	    $fileHandler = fopen($backupArchivo, 'w+');
	    fwrite($fileHandler, $outsql);
	    fclose($fileHandler);
 
	    // Se descarga el sql desde el navegador que este en uso
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . basename($backupArchivo));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($backupArchivo));
	    ob_clean();
	    flush();
	    readfile($backupArchivo);
	    exec('rm ' . $backupArchivo);
	}
?>