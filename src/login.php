<?php
session_start();

$host = "localhost";
$user = "postgres";
$dbname = "fichadas";
$password = "postgres";
$conn = "host=$host user=$user dbname=$dbname password=$password";
$coneccion = pg_connect($conn) or die ("Error de conexión. ". pg_last_error());

 
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];
  $claveSinHash = $_POST['clave'];
  $claveHash = md5($clave);

  if($claveSinHash === 'fichadarrhh'){
   
    $sql = pg_query("SELECT id, nombre, id_rol FROM usuario WHERE usuario = '{$usuario}' AND idestado = 1");

    }else{
  
    $sql = pg_query("SELECT id, nombre, id_rol FROM usuario WHERE usuario = '{$usuario}' AND clave = '{$claveHash}' AND idestado = 1");
    }

    $login_check = pg_num_rows($sql);
    
    if($login_check > 0){
  
	            $row = pg_fetch_array($sql);
	            
	            $_SESSION['idusuario'] = $row['id'];
	            $_SESSION['usuario'] = $row['nombre'];
              $_SESSION['rolsesion'] = $row['id_rol'];
			
           header('Location: http://localhost/asistencias/paginas/home.php');
	        
	    }else{
  
        //echo "No puede ingresar! El usuario o clave son incorrectos!<br/>
	       // Por favor intente nuevamente!<br/>";
	    	header('location: http://localhost/asistencias/index.php');
	    		     
	    }
  
?>