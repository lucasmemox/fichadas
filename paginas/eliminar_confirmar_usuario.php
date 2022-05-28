<!doctype html>
<?php

require_once '../src/fichadas.php';

// TOMO LOS DATOS DEL FORMULARIO
if (!empty($_POST)) {
 
    $idusuario = $_POST['idusuario'];

    // $consultaBorrar = pg_query("DELETE * FROM usuarios WHERE idusuario = '{$idusuario}'");
    $consultaBorrar = pg_query("UPDATE  usuario 
                                SET idestado = 2
                                WHERE id= '{$idusuario}'");

    if($consultaBorrar){
        header("Location: usuarios.php");
    }else{
        echo "Error al Eliminar el Usuario!!!";
    }
}

// TOMO LOS DATOS ENVIADOS DESDE USUARIOS
if (empty($_REQUEST['id'])) {
    header("Location: usuarios.php");
} else {
    
    $idusuario = $_REQUEST['id'];

    $consulta = pg_query("SELECT u.usuario ,u.nombre , r.rol as rol  FROM  usuario u, rol r
                          WHERE u.id_rol = r.id and u.id = '{$idusuario}'");

    $resuconsulta = pg_num_rows($consulta);

    if ($resuconsulta > 0) {
        while ($datos = pg_fetch_array($consulta)) {

            $usuario = $datos['usuario'];
            $nombre = $datos['nombre'];
            $rol = $datos['rol'];
        }
    } else {
        header("Location: usuarios.php");
    }
}
?>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href=".../imagenes/favicon.ico">
    <link href="../css/estilos.css" rel="stylesheet" type="text/css" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4cee06ab99.js" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/4cee06ab99.js" crossorigin="anonymous"></script>

    <title>Eliminar Usuario</title>
  </head>

  <body>
  <div class="col-12 contenedor-eliminar-usuarios-grid ">
        <div class="col-12 cabecera">
            <header>
                <div class="col-12 cabecera-nav">
                    <a href="../index.html"><img src="../imagenes/utn_fondo.png" alt="Logo"
                            title="UTN FRCU" class="logo-imagen"></a>
                    <nav class="navbar navbar-expand-md">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <!-- <span class="navbar-toggler-icon"></span> -->
                                <span><img src="./iconos/hamburguesa.png" alt="Logo" class="logo-acordeon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                                <ul class="navbar-nav my-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./home.php">Inicio</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page"
                                            href="./paginas/conocenos.html">Conocenos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./paginas/fotos.html">Fotos</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Usuarios
                                        </a>
                                        <ul class="dropdown-menu fondo-desplegable" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="../paginas/usuarios.php">Usuarios</a></li>
                                            <li><a class="dropdown-item" href="../paginas/registro-usuarios.php">Registrar Usuarios</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                         </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./paginas/inscripciones.html">Inscripción 2022</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="./paginas/contacto.html">Contacto</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
        </div>

        <div class="principal-eliminar-usuarios">
            <main>
                <div class="contenedor-usuario-editar">
                    <article class="art-index">
                        <div class="titulo">
                            <div class="titulo-contenido">
                                <h1>DESACTIVAR USUARIO</h1>
                            </div>
                        </div>
                    </article>
                </div>

                    <section class="container">
                    <div class="contenedor-eliminar-usuario">
                        <h2>Esta seguro de Desactivar el Usuario?</h2>
                        <p>Nombre:<span><?php echo $nombre; ?></span></p>
                        <p>Usuario:<span><?php echo $usuario; ?></span></p>
                        <p>Rol:<span><?php echo $rol; ?></span></p>
                        
                    <form method="post" action="">
                    <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>"/>    
                    <a href="../paginas/usuarios.php" class="btn-cancelar">Cancelar</a>
                    <input type="submit" value="Aceptar" class="btn-aceptar"/>
                    </form>
                    </div>

                </section>

            </main>

        </div>

        <div class="piepagina">
            <footer>
                <div class="piepagina-contenedor">
                    <div class="info-pie">
                        <div class="logo-pie">
                            <a href="./index.html"><img src="../imagenes/utn_fondo.png" alt="Logo"
                                    title="UTN FRCU" class="logo-pie"></a>
                        </div>
                        <div class="datos-infopie">
                            <a href="https://goo.gl/maps/NQ6XJQyDseoXb2oT7" target="_blank"><i
                                    class="fa-solid fa-house-user"></i>Ingeniero Pereyra 676</a>
                            <a href="#"><i class="fa-solid fa-location-crosshairs"></i>Concepción del Uruguay - Entre Ríos-
                                Argentina</a>
                            <a
                                href="whatsapp://send?text=Hola, Index.pe&phone=+54 9 3446 63 8755&abid=+54 9 3446 63 8755"><i
                                    class="fa-solid fa-mobile-screen"></i>+54 9 3442 425541</a>
                            <a href="mailto:danzaspamelarodriguez@gmail.com?Subject=Mas%20Informacion"><i
                                    class="fa-solid fa-envelope"></i>stics@frcu.utn.edu.ar </a>
                        </div>
                    </div>
                    <div class="clases-pie">
                        <h2>Mapa del Sitio</h2>

                        <div class="datos-clases-pie">
                            <a href="#">Inicio</a>
                            <a href="#">Cambiar Clave</a>
                            <a href="#">Reportes</a>
                            <a href="#">Salir</a>
                        </div>
                    </div>
                    <div class="horarios-pie">
                        <h2>Redes</h2>
                        <div class="datos-horarios-pie">
                            <a href="https://www.facebook.com/UTNCdelU/"><i
                                    class="fa-brands fa-facebook"></i>Facebook</a>
                            <a href="https://www.instagram.com/utnfrcu/"><i class="fa-brands fa-instagram-square"></i>Instagram</a>
                            <a href="https://www.youtube.com/c/UTNFRCU-XXI"><i
                                    class="fa-brands fa-youtube"></i>Youtube</a>
                        </div>
                    </div>
                    <div class="derechos-pie">
                        <div class="datos-derechos-pie">

                            <p>Universidad Tecnológica Nacional - FRCU &copy; 2022 | Todos los derechos reservados</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
  </body>
  </html>