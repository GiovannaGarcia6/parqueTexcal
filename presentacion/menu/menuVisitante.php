<?php
  session_start();//Se inicia la sesión.
  //Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
  if(isset($_SESSION['usuario'])){
    //Se obtiene el id del usuario
    $id = htmlentities($_GET['id']);
    //Requerimos del archivo para realizar la conexión.
    require $_SERVER['DOCUMENT_ROOT'].'/sistema web/datos/conexionBD.php';
    //Se crea un query que permite obtener nombre y apellido paterno del Visitante 
    $buscar=mysqli_query($conn,"SELECT nombVisit, apellPatVisit FROM Visitante WHERE idVisitante = '" . $id . "'");
    $filas=mysqli_fetch_array($buscar);
    //Se obtienen los datos del juego.
    $nombre = $filas['nombVisit'];
    $apellido = $filas['apellPatVisit'];
    mysqli_close($conn); //Se cierra la conexión de la bd.
  }else{
    //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
    header("Location: ../login/login.php");
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú Visitante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="../css/estilos_Menu.css">
    <link rel="stylesheet" href="../css/estilos_MenuVisitante.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body class="grid-container">
    <div class="row">
      <nav>
        <a href="#" class="enlace"><img src="../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a> 
      </nav>
    </div>
    <div class="row contenido">
      <aside id="aside" class="col-12 col-sm-12 col-md-3">
        <br><br>
        <i style="font-size:100px; color: white;" class="fa-solid fa-circle-user"></i>
        <br><br>
        <p>Visitante</p>
        <p><?php echo "".$nombre." ".$apellido;?></p>
        <br><br>
        <br><br>
        <a href="../../logica/login/cerrarSesion.php">Cerrar Sesión</a>
      </aside>
      <section id="section" class="col-xs-12 col-sm-12 col-md-9">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <a class="linkCard" href="../visitante/comentario/comentarios.php?id=<?php echo $id;?>">
              <div class="card tarjeta">
                <div class="card-body">
                  <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-message"></i></p>
                  <p class="card-text" style="text-align: center; font-size:20px">Comentarios</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <a class="linkCard" href="../visitante/visitaGuiada/agregarVisita.php?id=<?php echo $id;?>">
              <div class="card tarjeta">
                <div class="card-body">
                  <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-tree"></i>  <i class="fa-solid fa-vest-patches"></i></p>
                  <p class="card-text" style="text-align: center; font-size:20px">Reservar visita</p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <a class="linkCard" href="../visitante/visitaGuiada/solicitudVisitas.php?id=<?php echo $id;?>">
              <div class="card tarjeta">
                <div class="card-body">
                  <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-file"></i>  <i class="fa-solid fa-vest-patches"></i></p>
                  <p class="card-text" style="text-align: center; font-size:20px">Ver solicitudes de visitas</p>
                </div>
              </div>
            </a>
          </div>


          <div class="col-12 col-sm-12 col-md-6 col-lg-4">
            <a class="linkCard" href="../visitante/visitaGuiada/visitasPendientes.php?id=<?php echo $id;?>">
              <div class="card tarjeta">
                <div class="card-body">
                  <p class="card-title" style="text-align: center; font-size:60px"> <i class="fa-solid fa-vest-patches"></i></p>
                  <p class="card-text" style="text-align: center; font-size:20px">Ver visitas pendientes</p>
                </div>
              </div>
            </a>
          </div>





        </div>
      </section>
    </div>
    <div class="row">
      <footer>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-3 datos">
            <div class="logo">
              <div class="card-body">
                <center><img src="../media/imagenes/logo.png" alt="" class="logoFooter"><center>                    
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-9 datos2">
            <div class="datosFooter">
              <div class="card-body ">
                <p class="card-text" style="color:white; font-size:18px">© Derechos Reservados, Parque Estatal "El Texcal" 2022</p>
                <p class="card-text" style="color:Yellow; font-size:20px;">DIRECCIÓN</p>
                <p class="card-text" style="color:white; font-size:18px;">Av. El Texcal 62, Unidad Habitacional El Texcal, Jiutepec, Morelos, México. 62573</p>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  </body>
</html>