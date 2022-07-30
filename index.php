<!doctype html>
<?php
require 'src/fichadas.php';
?>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" href="./imagenes/favicon.ico">
    <link href="./css/estilos.css" rel="stylesheet" type="text/css" />
    <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4cee06ab99.js" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/4cee06ab99.js" crossorigin="anonymous"></script>
  
    <title>Fichadas UTN-FRCU</title>
  </head>
  
  <body>

  <div	class="d-flex flex-column min-vh-100 justify-content-center align-items-center"
	id="template-bg-3">

	<div class="card mb-5 p-5  bg-dark bg-gradient text-white col-md-4">
		<div class="card-header text-center">
			<h3>Iniciar sesión </h3>
		</div>
		<div class="card-body mt-3">
			<form action="src/login.php" method="post">
				<div class="input-group form-group mt-3">
					<input type="text" class="form-control text-center p-3"
						placeholder="Legajo" name="usuario">
				</div>
				<div class="input-group form-group mt-3">
					<input type="password" class="form-control text-center p-3"
						placeholder="Contraseña" name="clave">
				</div>
				<div class="text-center">
					<input type="submit" value="Acceder"
						class="btn btn-primary mt-3 w-100 p-2" name="login-btn">
				</div>
			</form>
                <?php if(!empty($loginResult)){?>
                <div class="text-danger"><?php echo $loginResult;?></div>
                <?php }?>
            </div>
		<div class="card-footer p-3">
			<div class="d-flex justify-content-center">
				<div class="text-primary">Fichadas del Personal No Docente UTN FRCU.</div>
			</div>
		</div>
	</div>

</div>
       
  </body>
</html>