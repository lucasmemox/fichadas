<?php
session_start();
include '../src/fichadas.php';
$rolUsuario = $_SESSION['rolsesion'];

$exportar = $_REQUEST['exportar'];
$buscar = $_REQUEST['buscar'];
$fechadesde = $_REQUEST['fechadesde'];
$fechahasta = $_REQUEST['fechahasta'];

echo "exportar: ".$exportar;
echo "buscar: ".$buscar;
echo "buscar: ".$buscar;
echo "buscar: ".$buscar;

if (!empty($exportar)) {
//get records from database
    echo "ingreso a exportar: ";
    if ($fechadesde == $fechahasta) {
        $query = pg_query("SELECT r.id, p.nombre, p.legajo, r.fecha , r.horas ,r.ingreso
                from registros r, personal p
                where r.legajo = p.legajo and
                r.fecha = '{$fechadesde}'
                order by 2,4,5");
    } else {
        $query = pg_query("SELECT r.id, p.nombre, p.legajo, r.fecha , r.horas ,r.ingreso
        from registros r, personal p
        where r.legajo = p.legajo and
        r.fecha between '{$fechadesde}' and '{$fechahasta}'
        order by 2,4,5 asc");
    }

    $check = pg_num_rows($query);
    
    // Creamos y abrimos un archivo con el nombre 'archivo.csv' para escribir los datos que recibimos del formulario
    $fp = fopen('fichada.txt', 'w+');

    if ($check > 0) {
        
       while ($row = pg_fetch_array($query)) {

            $datos .= $row['id'] . "," . $row["nombre"] . "," . $row['legajo'] . "," . $row['fecha'] . "," . $row['horas'] . "," . $row['ingreso']."\n";

            // Escribimos los datos en el archivo 
            fwrite($fp, $datos);            
            
        }

        // Después de terminar de escribir los datos, cerramos el archivo 
        fclose($fp);
    }
    
    
    header('Location: buscar_reportes.php?estado=1');
    exit();
    
}

if (!empty($buscar)) {
// Redireccionamos a la página del formulario, le pasamos el estado en 1
    header('Location: buscar_reportes.php?estado=0');

}
