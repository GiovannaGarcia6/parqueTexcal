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
        <!-- Codificación de caracteres utilizada en el documento -->
        <meta charset="utf-8">
        <!-- viewport para el diseño responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Título de la página que se visualiza en la pestaña desde el navegador -->
        <title>Reportes</title>
        <!-- Links de estilos -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="../../css/estilos_Reportes.css">

        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    </head>
    <body class="grid-container">
        <!-- Div que contiene el navBar con el logo y nombre del sistema -->
        <div class="row">
            <nav class="col-xs-12 col-sm-12 col-md-12">
                <a href="#" class="enlace"><img src="../../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
            </nav>
        </div>
        </div>
        <!-- Div que contiene la opción de regresar a la sección anterior enviando las variables
        necesarias para que se muestren los datos correspondientes -->
        <div class="row">
            <aside id="aside" class="col-xs-12 col-sm-12 col-md-12">
                <a href="../../menu/menuAdministrador.php?id=<?php echo $id;?>">Volver</a>
            </aside>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-4 section"> 
                <div class="col-11 encabezadoParametros">
                    <center><h3>Parámetros</h3></center>
                </div>

                <!--Fomulario que contiene los parámetros para realizar el reporte-->
                <form method="post" class="col-11 card cuerpoParametros">
                 
                    <!--Input no visible del id del administrador-->
                    <input type="hidden" name="idAdmin" value="<?php echo $id;?>">
                    <!--Selector con la sección a aplicar los parámetros-->
                    <div class="col-12">
                        <h4><i class="fa-solid fa-clipboard-check"></i> Sección</h4> 
                        <select class="form-select" name="seccion" onchange="habilitar(this);" aria-label="Default select example" required>
                            <option  selected value="Comentarios">Comentarios</option>
                            <option value="Mantenimientos">Mantenimientos</option>
                        </select>
                    </div>
                    <br>
                    <!--Selector del primer parámtro que corresponde al servicio-->
                    <div class="col-12" id="parametro1">
                        <h4><i class="fa-solid fa-magnifying-glass"></i> Buscar por servicio: </h4>  
                        <select class="form-select" name="buscarXServicio" aria-label="Default select example" >
                            <option selected value="1">Balneario</option>
                            <option value="2">Caminatas</option>
                            <option value="3">Visitas guiadas</option>
                            <option value="4">Ciclismo</option>
                            <option value="5">Todos</option>
                        </select>
                    </div>
                    <br>
                    <!--Selector del parametro 2 que corresponde a filtrar los comentarios por positivos y negativos-->
                    <div class="col-12" id="parametro2">
                        <h4><i class="fa-solid fa-filter"></i> Filtrar:</h4>  
                        <select class="form-select" name="puntuacion" aria-label="Default select example">
                            <option selected value="Positivos">Positivos</option>
                            <option value="Negativos">Negativos</option>
                        </select>
                    </div> 
                    <!--Parámetro 3 que corresponde a dos inputs de tipo date para realizar un rango de fechas en que se realizaron los mantenimientos-->
                    <div class="col-12" id="parametro3">
                        <h4><i class="fa-solid fa-magnifying-glass"></i> Buscar por fecha: </h4>  
                        <br> 
                        <h6>Fecha inicio</h6>
                        <input type="date" autocomplete="off" class="form-control" name="fechaInicio" placeholder="Fecha de inicio" aria-label="Username" aria-describedby="addon-wrapping">
                        <br>
                        <h6>Fecha termino</h6>
                        <input type="date" autocomplete="off" class="form-control" name="fechaTermino" placeholder="Fecha termino" aria-label="Username" aria-describedby="addon-wrapping" >
                    </div>
                    <br>
                    <!--Botón para aplicar los parámetros-->
                    <button class="btnAplicar btn-lg" type="submit">Aplicar</button>
                </form>
            </div>
            <div class="col-12 col-sm-12 col-md-8 section">
                <div class="col-11 encabezadoResultados">
                    <center><h3>Resultados</h3></center>
                </div>
                
                <div class="col-11 card cuerpoResultados">
                    <?php 
                        require $_SERVER['DOCUMENT_ROOT'].'/sistema web/logica/reportes/reportes.php';
                        //Se verifica que existan las variables enviada por el método POST
                        if((isset($_POST['seccion']) && isset($_POST['buscarXServicio']) && isset($_POST['puntuacion']) && isset($_POST['idAdmin'])) || (isset($_POST['seccion']) && isset($_POST['fechaInicio']) && isset($_POST['fechaTermino']) && isset($_POST['idAdmin']))){
                            
                            //Se obtiene el id del administrador y la sección
                            $idAdmin = htmlentities($_POST['idAdmin']);
                            $seccion = htmlentities($_POST['seccion']);

                            //De acuerdo a la sección elegida se obtendran los demas datos
                            if($seccion ==="Comentarios"){
                                //Si la sección elegida es comentarios, se obtiene el servicio y el filtro por el cual se realizará la búsqueda de los comentarios
                                $servicio = htmlentities($_POST['buscarXServicio']);
                                $filtro = htmlentities($_POST['puntuacion']);
                                //Se llama a la función para mostrar el resultado del reporte
                                mostrarResultados($idAdmin, $seccion, $servicio, $filtro);
                            }else{
                                //Si la sección es de mantenimientos, se obtiene el rango de fechas en las que se realizaron las actividades
                                $fechaInicio = $_POST['fechaInicio'];
                                $fechaTermino = $_POST['fechaTermino'];
                                //Se llama a la función para mostrar el resultado del reporte
                                mostrarResultados($idAdmin, $seccion, $fechaInicio, $fechaTermino);
                            }
                        }
                    ?>
                </div>
            </div>  
        </div>
       <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
       <div class="row">
            <footer>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 footer1"> </div>
                </div>
                <div class="row footerRow">
                    <!--Logo-->
                    <div class="col-xs-12 col-sm-12 col-md-3 datos1">
                        <div class="logo">
                            <div class="card-body">
                                <center><img src="../../media/imagenes/logo.png" alt="" class="logoFooter"></center>
                            </div>
                        </div>
                    </div>
                    <!--Información del parque-->
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
        <!--Script para ocultar los parámetros correspondientes de acuerdo a la sección-->
        <script>
            var parametro1 = document.getElementById('parametro1');
            var parametro2 = document.getElementById('parametro2');
            var parametro3 = document.getElementById('parametro3');

            parametro1.style.display = ''; // hide
            parametro2.style.display = ''; // hide
            parametro3.style.display = 'none'; // hide
        </script>

        <!-- Script para habilitar los parámetros -->
        <script src="../../../logica/js/habilitarParametros.js"></script><!--Determina si se habilita o no los parametros-->
        <!--Script de Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>
</html>