<?php 
  $texto = $_POST['busqueda'];
  $fechadesde = $_POST['fechadesde'];
  $fechahasta = $_POST['fechahasta'];

  if(isset($_POST['buscar'])){
    header("Location: buscar_reportes.php?".$busqueda."=&fechadesde=".$fechadesde."=&fechahasta=".$fechahasta."");
  } 
  if(isset($_POST['exportar'])){
    header("Location: archivo_csv.php?".$busqueda."=&fechadesde=".$fechadesde."=&fechahasta=".$fechahasta."");
  }
?>