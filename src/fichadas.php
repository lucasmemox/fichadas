<?php

$host = "localhost";
$user = "postgres";
$dbname = "fichadas";
$password = "postgres";
$conn = "host=$host user=$user dbname=$dbname password=$password";
$coneccion = pg_connect($conn) or die ("Error de conexión. ". pg_last_error());

?>
