<?php
session_start();
include '../src/fichadas.php';
$rolUsuario = $_SESSION['rolsesion'];

$exportar = $_REQUEST['exportar'];
$buscar = $_REQUEST['buscar'];
$busqueda = $_REQUEST['busqueda'];
$fechadesde = $_REQUEST['fechadesde'];
$fechahasta = $_REQUEST['fechahasta'];

if (!empty($exportar)) {

    echo "ingrese al exportar";

    if($fechadesde == $fechahasta && empty($busqueda)){
        $query = pg_query("SELECT p.legajo, r.fecha , r.horas ,r.ingreso  
                    from registros r, personal p  
                    where r.legajo = p.legajo and 
                    r.fecha = '{$fechadesde}' 
                    order by 1,2,3");
    } else {

        if($fechadesde == $fechahasta && !empty($busqueda)){
            
        $query = pg_query("SELECT p.legajo, r.fecha , r.horas ,r.ingreso 
        from registros r, personal p  
        where r.legajo = p.legajo and 
        r.fecha = '{$fechadesde}' and  p.nombre ilike '".$busqueda."%'
        order by 1,2,3");
        }
    }

    if($fechadesde != $fechahasta && empty($busqueda)){

        $query = pg_query("SELECT p.legajo, r.fecha , r.horas ,r.ingreso  
            from registros r, personal p  
            where r.legajo = p.legajo and 
            r.fecha between '{$fechadesde}' and '{$fechahasta}' 
            order by 1,2,3");
    }else{
        if($fechadesde != $fechahasta && !empty($busqueda)){
            
            echo "ingrese al fecha <>   busqueda con valor";

            $query = pg_query("SELECT p.legajo, r.fecha , r.horas ,r.ingreso  
            from registros r, personal p  
            where r.legajo = p.legajo 
            and   r.fecha between '{$fechadesde}' and '{$fechahasta}' 
            and  p.nombre ilike '".$busqueda."%'
            order by 1,2,3");
        }
    }
   
    $check = pg_num_rows($query);
    
    // Creamos y abrimos un archivo con el nombre 'archivo.csv' para escribir los datos que recibimos del formulario
    $fp = fopen('../fichada.txt', 'w+');
   
    if ($check > 0) {
        
       while ($row = pg_fetch_array($query)) {

            $datos .= $row['legajo'] . "," . $row['fecha'] . "," . $row['horas'] . "," . $row['ingreso']."\n";
        }
        
        // Escribimos los datos en el archivo 
        fwrite($fp, $datos);  
         
        // Después de terminar de escribir los datos, cerramos el archivo 
        fclose($fp);
    }
    
    header('Location: buscar_reportes.php?estado=1');
    exit();
    
}

if (!empty($buscar)) {
// Redireccionamos a la página del formulario, le pasamos el estado en 1
    header('Location: buscar_reportes.php?busqueda='.$busqueda.'&fechadesde='.$fechadesde.'&fechahasta='.$fechahasta);
}
