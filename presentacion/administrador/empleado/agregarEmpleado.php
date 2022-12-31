<?php
    session_start();//Se inicia la sesión.
    //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
    if(isset($_SESSION['usuario'])){
        //Se obtiene el id del usuario
        $id = htmlentities($_GET['id']);
    }else{
        //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
        header("Location: ../../login/login.php");
    }  
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nuevo empleado</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_AgregarEmpleado.css">
    </head>
    <body class="grid-container">
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="./empleados.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <section id="section"  class="col-12 col-sm-12 col-md-12">
                <div class="col-11 col-sm-8 col-md-4 formulario">
                    <form action="../../../logica/gestionEmpleado/agregarEmpleado.php?id=<?php echo $id;?>" method="post"> 
                        <h2  style="text-align: center">NUEVO EMPLEADO</h2>
                        <!--Se muestra el mensaje de éxito o de error-->
                        <?php if(isset($_SESSION['status'])){ 
                                if($_SESSION['status']=='Empleado registrado con éxito.'){
                        ?>
                                    <div id="alerta" class="alert alert-success d-flex align-items-center" role="alert">
                                        <?php echo $_SESSION['status']; ?>
                                    </div><br>  
                        <?php   }else{?> 
                                    <div id="alerta" class="alert alert-danger d-flex align-items-center" role="alert">
                                    <?php echo $_SESSION['status']; ?>
                                    </div> <br>     
                        <?php   } header("refresh:1; url = ./agregarEmpleado.php?id=$id");unset($_SESSION['status']); } ?><!--Se elimina la variable de sesión-->
                        

                         <!--Selector del servicio-->
                         <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-users icono"></i></span>
                            <select class="form-select" name="tipoEmpleado" aria-label="Username" required>
                                <option value="">Tipo de empleado</option>
                                <option value="Guia">Guia</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>
                        <!--Nombre del empleado-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text span" id=""><i class="fa-solid fa-user icono"></i></span>
                            <input type="text" autocomplete="off" class="form-control" name="nombre" placeholder="Nombre" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>
                        <!--Apellido Paterno del empleado-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                            <input type="text" autocomplete="off" class="form-control" name="apPaterno" placeholder="Apellido Paterno" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>
                        <!--Apellido Materno del empleado-->
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-user icono"></i></span>
                            <input type="text" autocomplete="off" class="form-control" name="apMaterno" placeholder="Apellido Materno" aria-label="Username" aria-describedby="addon-wrapping">
                        </div>
                         <!--Email del empleado-->
                         <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-envelope icono"></i></span>
                            <input type="email" autocomplete="off" class="form-control" name="correo" placeholder="Correo electrónico" aria-label="Username" aria-describedby="addon-wrapping" required>
                        </div>
                        <!--Contraseña del empleado-->
                        <?php
                            $combinacion = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890./*$';
                            $pass = array(); 
                            $combLen = strlen($combinacion) - 1; 
                            for ($i = 0; $i < 10; $i++) {
                                $n = rand(0, $combLen);
                                $pass[] = $combinacion[$n];
                            }
                        ?>
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" id=""><i class="fa-solid fa-lock icono"></i></span>
                            <input type="password" id="password" autocomplete="off" value="<?php print(implode($pass));?>" class="form-control" name="contra" placeholder="Contraseña" aria-label="Username" aria-describedby="addon-wrapping" required>
                            <button class="btnMostrarContra" type="button" onclick="mostrarContrasena()"><i id="icono" class="fa-solid fa-eye icono"></i></button>
                        </div>
                        <button class="btnRegistrar btn-lg" type="submit">Registrar</button>
                    </form>       
                </div>
                
            </section>  
        </div>
       <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
       <div class="row">
            <footer>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
                </div>
                <div class="row footerRow">
                    <div class="col-xs-12 col-sm-12 col-md-3 datos1">
                        <div class="logo">
                            <div class="card-body">
                                <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-9 datos2">
                        <div class="card-body ">
                            <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>
                            <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                            <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
                        </div>
                    </div>
                </div>   
            </footer>
        </div>
        <script>
            function mostrarContrasena(){
                var tipo = document.getElementById("password");
                var icono = document.getElementById("icono");
                if(tipo.type == "password"){
                    tipo.type = "text";
                    icono.className ="fa-solid fa-eye-slash icono";
                }else{
                    tipo.type = "password";
                    icono.className ="fa-solid fa-eye icono";
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>