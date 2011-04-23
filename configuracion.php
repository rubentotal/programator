<HTML LANG="es">

<HEAD>
   <TITLE>Programator</TITLE>
   <LINK REL="stylesheet" TYPE="text/css" HREF="css/estilo.css"> 
   <meta http-equiv="Content-Type" content="text/html; charset=utf8_spanish2_ci">

</HEAD>

<BODY>

<?php

// Conectar a la base de datos
require_once 'db/BD_conexion.php';
require_once 'programator.php';
require_once 'interfaz.php';

function mostrarConfiguracion(){
    // Conectar con el servidor de base de datos
    $conexion = $BD = new BD_conexion();

    echo "<h1>Evaluaciones</h1>";
    $sql = "SELECT * FROM evaluaciones";
    $BD->escribir_consulta($sql);

    echo "<h1>Vacaciones</h1>";
    $sql = "SELECT * FROM vacaciones";
    $BD->escribir_consulta($sql);

    echo "<h1>Festivos</h1>";
    $sql = "SELECT * FROM festivos";
    $BD->escribir_consulta($sql);

    echo "<h1>Unidades</h1>";
    $sql = "SELECT * FROM unidades";
    $BD->escribir_consulta($sql);
}

//mostrarConfiguracion();

//-------------------------
//$asignatura = 'DAE4G'; // DAE4G  SIF SIF-p
//$evaluaciones = "'1', '2'";

$asignatura = 'SIF'; // SIF
$evaluaciones = "'1', '2'";

//$asignatura = 'SIF-p'; // DAE4G  SIF SIF-p
//$evaluaciones = "'P'"; // contenido IN() de sql seleccion de tabla evaluaciones


$programator = new Programator();
$programator->programarDias($asignatura, $evaluaciones );
//$programator->printDias();
//$programator->printUnidades();

$interfaz = new Interfaz($asignatura , $programator->DIAS, $programator->UNIDADES);
$interfaz->printDiasByRango($f1, $f2);


?>

</BODY>
</HTML>
