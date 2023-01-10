<?php
    /*  
        Nombre de la función: consultarEmpleadoBuscador
        Entrada:Frase o palabra a buscar.
        Salida: Resultado con los datos de la consulta

        Descripción: La función realiza una consulta a la base de datos de acuerdo a lo que indique el buscador, para si obtener
        los registros que cumplan con las condiciones.
    */
    function consultarEmpleadoBuscador($buscador){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //si el buscador esta vacío se crea un sql para mostrar los datos de los
            //empleados almacenados en la base de datos. 
            $sql = "SELECT idTrabajador, tipoTrab, nombreTrab, apellPatTrab, apellMatTrab, correoTrab from Trabajador";

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla empleados
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla Empleados se obtienen los campos de id, tipo de trabajador, nombre, apellidos y correo.
            
            $sql = "SELECT idTrabajador, tipoTrab, nombreTrab, apellPatTrab, apellMatTrab, correoTrab from Trabajador
            where idTrabajador like '%".$buscador."%' or tipoTrab like '%".$buscador."%' or nombreTrab like '%".$buscador."%' 
            or apellPatTrab like '%".$buscador."%' or apellMatTrab like '%".$buscador."%' or correoTrab like '%".$buscador."%'";
          
        }
              
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado; //Se retorna el resultado con los registros que coinciden con la búsqueda.

        mysqli_close($conn);//Se cierra la conexión

    }

    /*  
        Nombre de la función: agregarEmpleado
        Entrada: Tipo del trabajador, nombre, apellido paterno, apellido materno, correo y contraseña.
        Salida: Se retorna 1 o 0, según sea el caso de la ejecuciónta

        Descripción: La función realiza una inserción de un nuevo trabajador con los datos enviados por el usuario.
    */
    function agregarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Trabajador (tipoTrab,nombreTrab,apellPatTrab,apellMatTrab,correoTrab,contraTrab) values ('".$tipoEmpleado."','".$nombre."','".$apellidoPaterno."','".$apellidoMaterno."','".$correo."',md5('".$contrasena."'))";
        
        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        
        mysqli_close($conn);//Se cierra la conexión
 
    }

    /*  
        Nombre de la función: actualizarEmpleado
        Entrada: Id del trabajador, tipo, nombre, apellido paterno, apellido materno, correo y contraseña.
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza una actualización de la información del trabajador con los datos enviados por el usuario.
    */
    function actualizarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena,$idTrabajador){
        
        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="UPDATE Trabajador SET  tipoTrab = '".$tipoEmpleado."', nombreTrab = '".$nombre."', apellPatTrab = '".$apellidoPaterno."', apellMatTrab = '".$apellidoMaterno."' , correoTrab = '".$correo."' WHERE idTrabajador='".$idTrabajador."'";
        
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    /*  
        Nombre de la función: eliminarEmpleado
        Entrada: Id del trabajdor
        Salida: Se retorna 1 o 0, según sea el caso de la ejecución

        Descripción: La función realiza la eliminación de un trabajador indicado por el usuario.
    */
    function eliminarEmpleado($idTrabajador){

        //Archivo que permite realizar la conexión con la base de datos
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        //Se realiza un query que realiza la eliminación del empleado que se indico con el id.
        $query="DELETE FROM Trabajador WHERE idTrabajador='".$idTrabajador."'";

        //Se ejecuta el query
        if($conn->query($query) === TRUE){
            return 1; //Se retorna 1, si la ejecución del query fue exitosa
        }else{
            return 0; //Se retorna 0, si la ejecución del query fue erronea
        }
        
        mysqli_close($conn);//Se cierra la conexión
    }
?>