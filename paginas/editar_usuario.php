<!doctype html>
<?php
 
require_once('../src/fichadas.php'); 

// TOMO LOS DATOS ENVIADOS DESDE USUARIOS
if(empty($_GET['id'])){
    header("Location: usuarios.php");
}

$idusuario =  $_GET['id'];

$consulta= pg_query("SELECT u.id , u.usuario , u.clave, u.idestado, e.estado , u.nombre , u.id_rol as idrol, r.rol as rol  FROM  usuario u, rol r, estado e WHERE u.id_rol = r.id and u.idestado = e.id and u.id = '{$idusuario}'");

$resuconsulta =pg_num_rows($consulta);

if($resuconsulta == 0){
    header("Location: usuarios.php");
    }else{
        $option = '';
        while($datos = pg_fetch_array($consulta)){ 

            $idusuario =  $datos['id'];
            $usuario =  $datos['usuario'];
            $clave =  $datos['clave'];
            $idestado = $datos['idestado'];
            $estado =  $datos['estado'];
            $nombre =  $datos['nombre'];
            $idrol =  $datos['idrol'];
            $rol =  $datos['rol'];
            
            if($idrol == 1){
                $option= '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }else if($idrol == 2){
                $option= '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }else if($idrol == 3){
                        $option= '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }

            if($idestado == 1){
                $optionestado = '<option value="'.$idestado.'" select>'.$estado.'</option>';
            }else if($idestado == 2){
                $optionestado = '<option value="'.$idestado.'" select>'.$estado.'</option>';
            }
    }
}

// HAGO EL POST PARA ACTUALIZAR LOS DATOS 
if(!empty($_POST)){
    $alert='';
    if(empty($_POST["nombre"]) || empty($_POST["usuario"]) || empty($_POST["rol"]) || empty($_POST["estado"])){
        $alert='<p class="msg_error">Todos los campos son obligatorios </p>';
    }else{

        $iduser =  $_POST['idusuario'];
        $usuario =  $_POST['usuario'];
        $clave =  $_POST['clave'];
        $estado =  $_POST['estado'];
        $nombre =  $_POST['nombre'];
        $rol =  $_POST['rol'];

        $compUsuario = pg_query("SELECT  count(*)
                        FROM usuario 
                        WHERE (id != '{$iduser}' AND usuario = '{$usuario}') 
                        OR (id != '{$iduser}' AND nombre = '{$nombre}') 
                        ORDER BY count(*)");

        while($row = pg_fetch_row($compUsuario)){
            $editar_check = $row[0]; 
        };

        if($editar_check > 0){

            $alert='<p class="msg_error">El usuario o su nombre están en uso </p>';
        }else{

            if(empty($_POST["clave"])){
                $sql_actualizar = pg_query("UPDATE usuario
                                            SET  nombre = '{$nombre}', 
                                            usuario = '{$usuario}', 
                                            idestado = '{$estado}',
                                            id_rol    ='{$rol}'
                                            WHERE id ='{$iduser}'");                
            }else{
            $sql_actualizar = pg_query("UPDATE usuario
                                        SET  nombre = '{$nombre}', 
                                             usuario = '{$usuario}', 
                                             clave   = '{$clave}', 
                                             idestado = '{$estado}',
                                             id_rol    ='{$rol}'
                                             WHERE id ='{$iduser}'");
            }
           
            if($sql_actualizar){
                $alert='<p class="msg_guardar">El usuario fue Actualizado</p>';
            }else{
                $alert='<p class="msg_error">Error al actualizar el usuario</p>';
            }
        }
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
  
    <title>Actualizar Usuario</title>
  </head>

  <body>
  <div class="col-12 contenedor-editar-usuarios-grid ">
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
                                        <a class="nav-link" href="">Salir</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href=""><?php echo $_SESSION["usuario"];   ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
        </div>

        <div class="principal-editar-usuarios">
            <main>
                <div class="contenedor-usuario-editar">
                    <article class="art-index">
                        <div class="titulo">
                            <div class="titulo-contenido">
                                <h1>USUARIO</h1>
                            </div>
                        </div>
                    </article>
                </div>
                   
                    <section class="container">

                    <div class="form-editar">
                        <h1>ACTUALIZAR</h1>
                        <hr>

                        <div class="alerta_editar"><?php echo isset($alert) ? $alert : '' ?></div>
                        
                        <form action="" method="post">
                        <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $idusuario; ?>">
                        <label for="usuario">Usuario</label>
                        <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario?>">
                        <label for="clave">Clave</label>
                        <input type="password" name="clave" id="clave" placeholder="Clave" value="">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre?>">
                        <!-- SELECT ESTADO -->
                        <label for="estado">Estado</label>
                        <?php
                        $sql_estado = pg_query("SELECT *  FROM  estado");
                        $estado_check = pg_num_rows($sql_estado);
                        ?>
                        <select name="estado" id="estado" placeholder="estado" class="noseleccionado" >
                        <?php
                        echo $optionestado;
                         if($estado_check > 0){

                            while($filaestado = pg_fetch_array($sql_estado)){
                        ?>
                        <option value="<?php echo $filaestado["id"]; ?>"><?php echo $filaestado["estado"]; ?> </option>
                        <?php
                            }
                        }  
                        ?>
                        </select>
                        <!-- FIN SELECT ESTADO -->
                        <label for="rol">Rol</label>
                        <?php
                        $sql_rol = pg_query("SELECT *  FROM  rol");

                        $rol_check = pg_num_rows($sql_rol);

                        ?>
                        <select name="rol" id="rol" placeholder="Rol" class="noseleccionado">
                        <?php
                        echo $option;
                         if($rol_check > 0){

                            while($fila = pg_fetch_array($sql_rol)){
                        ?>
                        <option value="<?php echo $fila["id"]; ?>"><?php echo $fila["rol"]; ?></option>
                        <?php
                            }
                        }  
                        ?>
                        </select>    
                        <input type="submit" value="Actualizar Usuario" class="btn-editar">

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