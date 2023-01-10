<?php
/*
    Entrada: El nombre del servidor, el nombre del usuario, la contraseña, el nombre de la base de datos y la ubicación del archivo.
    Salida: Se retorna la variable $output la cual almacena un 1 si la restauración salio exitosa, caso contrario, un 0.

    Descripción: La función restaurarBD recibe los datos mandados de la capa lógica para posteriormente leer cada línea del
    archivo y ejecutarla para así realizar la restauración.
*/
function restaurarBD($server, $username, $password, $dbname, $location){
    //Se realiza la conexión a la base de datos.
    $conn = new mysqli($server, $username, $password, $dbname); 

    //La variable $sql almacena consultas del archivo sql
    $sql = '';
    
    //se obtiene el archivo sql
    $lines = file($location);

    //ciclo que lee linea por linea el script
    foreach ($lines as $line){

        //Salta los comentarios
        if(substr($line, 0, 2) == '--' || $line == ''){
            continue;
        }

        //se agrega cada línea a la variable que almacenara la sentencia
        $sql .= $line;

        //Se comprueba si es el final de la línea debido al punto y coma
        if (substr(trim($line), -1, 1) == ';'){
            //Se ejecuta la sentencia

            if($conn->query($sql) === TRUE){
                $output = 1;
            }else{
                $output = 0;
            }
            //Se limpia la variable para que sea utilizada para la siguiente linea
            $sql = '';
            
        }
    }

    //Se retorna la variable que almacena el resultado de la ejecución del script
    return $output;
}

?>