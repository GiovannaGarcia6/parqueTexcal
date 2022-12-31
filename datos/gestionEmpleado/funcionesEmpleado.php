<?php
    function consultarEmpleadoBuscador($buscador){

        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';

        if($buscador === ""){
            //En caso, de que no exista la variable buscador, se crea un sql para mostrar los datos de los
            //empleados almacenados en la base de datos. 
            $sql = "Select idTrabajador, tipoTrab, nombreTrab, apellPatTrab, apellMatTrab, correoTrab from Trabajador";

        }else{
            //Se crea una sentencia sql, en la que se seleccionan ciertos datos de la tabla empleados
            //para realizar una busqueda de aquellos registros que contengan datos iguales a lo que el usuario ingreso 
            //en el buscador.
            //De la tabla Empleados se obtienen los campos de id, tipo de trabajador, nombre, apellidos y correo.
            
            $sql = "Select idTrabajador, tipoTrab, nombreTrab, apellPatTrab, apellMatTrab, correoTrab from Trabajador
            where idTrabajador like '%".$buscador."%' or tipoTrab like '%".$buscador."%' or nombreTrab like '%".$buscador."%' 
            or apellPatTrab like '%".$buscador."%' or apellMatTrab like '%".$buscador."%' or correoTrab like '%".$buscador."%'";
          
        }
              
        //Se ejecuta la sentencia sql
        $resultado = mysqli_query($conn, $sql);

        return  $resultado;

        mysqli_close($conn);//Se cierra la conexión

    }


    function eliminarEmpleado($idTrabajador){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        //Se realiza un query que realiza las actualizaciones pertinentes de los datos obtenidos.
        $query="DELETE FROM Trabajador WHERE idTrabajador='".$idTrabajador."'";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
        mysqli_close($conn);//Se cierra la conexión
    }

    function agregarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena){
        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
        //Query que realiza la inserción de los datos cuando todos son correctos.
        $query  = "Insert into Trabajador (tipoTrab,nombreTrab,apellPatTrab,apellMatTrab,correoTrab,contraTrab) values ('".$tipoEmpleado."','".$nombre."','".$apellidoPaterno."','".$apellidoMaterno."','".$correo."',md5('".$contrasena."'))";
        //Si el query se ejecuta correctamente se muestra un mensaje de éxito.
        if($conn->query($query) === TRUE){
            return 1;
        }else{
           return 0;
        }

        mysqli_close($conn);//Se cierra la conexión
 
    }

    function actualizarEmpleado($tipoEmpleado, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $contrasena,$idTrabajador){
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
?>