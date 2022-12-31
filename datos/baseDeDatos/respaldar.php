<?php
 
	function respaldarBD($host, $user, $pass, $dbname, $tables = '*'){
		//make db connection
		$conn = new mysqli($host, $user, $pass, $dbname);
		if ($conn->connect_error) {
		    die("La conexión falló: " . $conn->connect_error);
		}
 
		//get all of the tables
		if($tables == '*'){
			$tables = array();
			$sql = "SHOW TABLES";
			$query = $conn->query($sql);
			while($row = $query->fetch_row()){
				$tables[] = $row[0];
			}
		}
		else{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
 
		//getting table structures
		$outsql = "-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)\n--\n-- Host: localhost    Database: parqueTexcal\n-- ------------------------------------------------------\n-- Server version	10.4.27-MariaDB		
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
";

        // $outsql .= "drop database parquetexcal;";
		// $outsql .= "\n"; 
		
		// $outsql .= "create database parquetexcal;";
		// $outsql .= "\n"; 
		
		// $outsql .= "use parquetexcal;";
		$outsql .= "\n"; 
        
		foreach ($tables as $table) {
    
			$outsql .= "--\n-- Table structure for table `$table`\n--";
			$outsql .= "\n"; 
			$outsql .= "\n"; 
			$outsql .= "DROP TABLE IF EXISTS `$table`;";
			$outsql .= "\n"; 

			$outsql .= "/*!40101 SET @saved_cs_client     = @@character_set_client */;";
			$outsql .= "\n"; 
			$outsql .= "/*!40101 SET character_set_client = utf8 */;";
		    // Prepare SQLscript for creating table structure
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
			 // Prepare SQLscript for dumping data for each table
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
 
		// Save the SQL script to a backup file
	    $backup_file_name = $dbname . '_backup.sql';
	    $fileHandler = fopen($backup_file_name, 'w+');
	    fwrite($fileHandler, $outsql);
	    fclose($fileHandler);
 
	    // Download the SQL backup file to the browser
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($backup_file_name));
	    ob_clean();
	    flush();
	    readfile($backup_file_name);
	    exec('rm ' . $backup_file_name);
	}
?>