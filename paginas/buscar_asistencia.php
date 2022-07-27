<!doctype html>
<?php
session_start();
include '../src/fichadas.php';
$rolUsuario = $_SESSION['rolsesion'];
?>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="../imagenes/favicon.ico">
    <link href="../css/estilos.css" rel="stylesheet" type="text/css" />
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4cee06ab99.js" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/4cee06ab99.js" crossorigin="anonymous"></script>

    <title>Fichadas UTN-FRCU</title>
  </head>

  <body>
  <div class="col-12 contenedor-asistencias-grid">
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
                                            href="../paginas/asistencias.php">Fichadas</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Usuarios
                                        </a>
                                        <ul class="dropdown-menu fondo-desplegable" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="./usuarios.php">Usuarios</a></li>
                                            <li><a class="dropdown-item" href="./registro_usuarios.php">Registrar Usuarios</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                         </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../salir.php">Salir</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href=""> | </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href=""><?php echo $_SESSION["usuario"]; ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
        </div>

        <div class="principal-fichadas">
            <main>
                <div class="contenedor-fichadas">
                    <article class="art-index">
                        <div class="titulo">
                            <div class="titulo-contenido">
                                <h1>FICHADAS NO DOCENTES</h1>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="contenedor-tabla-fichadas">
                <section class="contenedor-section-fichadas">
                <?php 
                    $busqueda = $_REQUEST['busqueda'];
                    $fechabusqueda = $_REQUEST['fecha'];
                 
                    if(empty($busqueda) && empty($fechabusqueda) ){
                        header("Location: asistencias.php");
                    }
                    ?>  
                    <!-- FORMULARIO DE BUSQUEDA -->
                    <form action="buscar_asistencia.php" method="get" class="formbusquedafichadas">
                        <input type="text" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>"placeholder="Buscar">
                        <input type="date" name="fecha" id="fecha" value="<?php echo $fechabusqueda; ?>" />
                        <input type="submit" value="Buscar" class="btn-buscar">
                    </form>
                    <!-- FIN DE BUSQUEDA -->
                    <table>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>LEGAJO</th>
                                <th>FECHA</th>
                                <th>HORAS</th>
                                <th>INGRESO</th>
                            </tr>
                            <?php
        //Paginador

//$sql_contador = pg_query("SELECT count(*) as total FROM  registros where fecha = '{$fechabusqueda}'");
if(empty($busqueda) ){
    $sql_contador = pg_query("SELECT count(*) from registros r, personal p  
    where r.legajo = p.legajo and 
    r.fecha = '{$fechabusqueda}'");
}else{
    $sql_contador = pg_query("SELECT count(*) from registros r, personal p  
where r.legajo = p.legajo and 
r.fecha = '{$fechabusqueda}' and  p.nombre ilike '".$busqueda."%'");
}

$resu_contador = pg_fetch_array($sql_contador);
$total = $resu_contador['total'];

$por_pagina = 20;

if (empty($_GET['pagina'])) {
    $pagina = 1;
} else {
    $pagina = $_GET['pagina'];
}

$desde = ($pagina - 1) * $por_pagina;

$total_paginas = ceil($total / $por_pagina);

if(empty($busqueda) ){
$sql = pg_query("SELECT r.id, p.nombre, p.legajo, r.fecha , r.horas ,r.ingreso  
            from registros r, personal p  
            where r.legajo = p.legajo and 
            r.fecha = '{$fechabusqueda}' 
            order by 2,4,5 asc LIMIT '{$por_pagina}'offset '{$desde}'");
}else{
$sql = pg_query("SELECT r.id, p.nombre, p.legajo, r.fecha , r.horas ,r.ingreso  
    from registros r, personal p  
    where r.legajo = p.legajo and 
    r.fecha = '{$fechabusqueda}' and p.nombre ilike '".$busqueda."%' 
    order by 2,4,5 asc LIMIT '{$por_pagina}'offset '{$desde}'");
}
$usuarios_check = pg_num_rows($sql);

if ($usuarios_check > 0) {

    while ($row = pg_fetch_array($sql)) {
        ?>
                            <tr>
                                <td><?php echo $row["id"] ?></td>
                                <td><?php echo $row["nombre"] ?></td>
                                <td><?php echo $row["legajo"] ?></td>
                                <td><?php echo $row["fecha"] ?></td>
                                <td><?php echo $row["horas"] ?></td>
                                <td><?php echo $row["ingreso"] ?></td>
                                </tr>
                        <?php
}
}
?>
                        </table>
                        <div class="paginador">
                            <ul>
                            <?php
if ($pagina != 1) {
    ?>
                                <li><a href="?pagina=<?php echo 1; ?>busqueda<?php echo $busqueda; ?>=&fecha=<?php echo $fechabusqueda; ?>">|<<</a></li>
                                <li><a href="?pagina=<?php echo $pagina - 1; ?>busqueda<?php echo $busqueda; ?>=&fecha=<?php echo $fechabusqueda; ?>"><<</a></li>
                            <?php
}
for ($i = 1; $i < $total_paginas; $i++) {
    if ($pagina = $i) {
        echo '<li class="pageseleccion">' . $i . '</li>';
    } else {
        echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
    }
}
if ($pagina != $total_paginas) {
    ?>
                                <li><a href="?pagina=<?php echo $pagina + 1; ?>busqueda<?php echo $busqueda; ?>=&fecha=<?php echo $fechabusqueda; ?>">>></a></li>
                                <li><a href="?pagina=<?php echo $total_paginas; ?>busqueda<?php echo $busqueda; ?>=&fecha=<?php echo $fechabusqueda; ?>">>>|</a></li>
                            <?php }?>
                            </ul>
                        </div>

                </section>
                </div>
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