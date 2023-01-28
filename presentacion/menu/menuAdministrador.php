<?php
session_start(); //Se inicia la sesión.
//Se verifica que exista la variable de sesión para que el usuario pueda acceder al menú.
if (isset($_SESSION['usuario'])) {
  //Se obtiene el id del usuario
  $id = htmlentities($_GET['id']);
  //Requerimos del archivo para realizar la conexión.
  require $_SERVER['DOCUMENT_ROOT'] . '/sistema web/datos/conexionBD.php';

  //Se crea un query que permite obtener nombre y apellido del trabajador
  $buscar = mysqli_query($conn, "SELECT nombreTrab, apellPatTrab FROM Trabajador WHERE idTrabajador = '" . $id . "'");
  $filas = mysqli_fetch_array($buscar);
  //Se obtienen los datos del usuario.
  $nombre = $filas['nombreTrab'];
  $apellido = $filas['apellPatTrab'];
  mysqli_close($conn); //Se cierra la conexión de la bd.
} else {
  //En caso de que no se encuentre la variable de sesión se redirige al inicio de sesión.
  header("Location: ../login/login.php");
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
  <title>Menú Administrador</title>
  <!-- links de estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../css/estilos_Menu.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<!-- Body con la clase grid-container que alinea el contenido -->

<body class="grid-container">
  <!-- Div que contiene el renglón con el logo y nombre del sistema -->
  <div class="row">
    <nav>
      <a href="#" class="enlace"><img src="../media/imagenes/logo.png" alt="" class="logo"><span> Parque Estatal "El Texcal"</span></a>
    </nav>
  </div>
  <div class="row contenido">
    <!-- Aside con la información y el icono de usuario -->
    <aside id="aside" class="col-12 col-sm-12 col-md-3">
      <br><br>
      <i style="font-size:100px; color: white;" class="fa-solid fa-circle-user"></i>
      <br><br>
      <p>Administrador</p>
      <p><?php echo "" . $nombre . " " . $apellido; ?></p>
      <br><br>
      <br><br>
      <!-- Opción para cerrar sesión -->
      <a href="../../logica/login/cerrarSesion.php">Cerrar Sesión</a>
    </aside>
    <!-- Sección con las opciones del menu de administrador -->
    <section id="section" class="col-xs-12 col-sm-12 col-md-9">
      <div class="row">
        <!-- Opción de archivero -->
        <div class="col-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/archivero/carpetas/archivero.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-box-archive"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Archivero</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de empleados -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/empleado/empleados.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-users"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Empleados</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de publicaciones -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/publicaciones/publicaciones.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-file-image"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Publicaciones</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de comentarios -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/comentarios/comentarios.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-message"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Comentarios</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de boletos -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/boletos/boletos.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-money-check-dollar"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Boletos</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de mantenimientos -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/mantenimientos/mantenimientos.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-screwdriver-wrench"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Mantenimiento</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de eventos -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/eventos/eventos.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-calendar-days"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Eventos</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de reportes -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/reportes/reportes.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-file-pdf"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Generar reportes</p>
              </div>
            </div>
          </a>
        </div>
        <!-- Opción de base de datos -->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
          <a class="linkCard" href="../administrador/base de datos/baseDeDatos.php?id=<?php echo $id; ?>">
            <div class="card tarjeta">
              <div class="card-body">
                <p class="card-title" style="text-align: center; font-size:60px"><i class="fa-solid fa-database"></i></p>
                <p class="card-text" style="text-align: center; font-size:20px">Base de datos</p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </section>
  </div>
  <!-- Footer de la página en la que contiene el logo y los datos de la empresa-->
  <div class="row">
    <footer>
      <div class="row">
        <!--Logo-->
        <div class="col-xs-12 col-sm-12 col-md-3 datos">
          <div class="logo">
            <div class="card-body">
              <center><img src="../media/imagenes/logo.png" alt="" class="logoFooter">
                <center>
            </div>
          </div>
        </div>
        <!--Información de la ubicación del parque-->
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
  <!-- Script de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>