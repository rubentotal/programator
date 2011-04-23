<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8_spanish2_ci">
        <link REL="stylesheet" TYPE="text/css" HREF="css/estilo.css">
        <title>Programator prueba</title>
    </head>
    <body>
        <?php
        require_once 'db/BD_conexion.php'; // Conectar a la base de datos

        if ( isset($_POST['Enviar'])){
            require_once 'programator.php';
            require_once 'interfaz.php';
            $asignatura = $_POST['asignatura'];
            $printConfiguracion = $_POST['printConfiguracion'];
            printProgramacion($asignatura, $printConfiguracion);

        }else{            
            echo "<h1>Asignaturas</h1>";
            printFormulario();
        }
        ?>
    </body>
</html>


<?php
    function printFormulario() {
        $BD = new BD_conexion();
        $BD->escribir_consulta("SELECT * FROM asignaturas");
        echo '<form name="formulario1" action="'.$_SERVER['PHP_SELF'].'" method="POST">';
        echo $BD->cargar_html_select("asignatura", "asignaturas", "Nombre", "Codigo");        
        echo '<input name="Enviar" type="submit" value="Programar" /><br>';
        echo '<input type="checkbox" name="printConfiguracion" value="false" /> Imprimir configuracion';
        echo '</form>';
       // $BD->cerrar();
    } 

    function printProgramacion($asignatura, $printConfiguracion) {
        if ($printConfiguracion){
            printConfiguracion();
        }

        $programator = new Programator();
        $evaluaciones = getEvaluaciones($asignatura);// chapuza
        echo "asignatura".$asignatura."<br>";
        echo "evaluaciones".$evaluaciones."<br>";
        $programator->programarDias($asignatura, $evaluaciones );
        //$programator->printDias();
        //$programator->printUnidades();

        $interfaz = new Interfaz($asignatura , $programator->DIAS, $programator->UNIDADES);
        $interfaz->printDiasByRango($f1, $f2); // $f1, $f2 no se estan utilizando
    }

    function printConfiguracion(){
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

    /** Devuelve las evaluaciones de docencia de una asignatura
     *<i><b>Yes, it's hardcoded and should be in the db :(</b></i>
     * @param <type> $asignatura codigo de la asinatura
     * @return <type>
     */
    function getEvaluaciones($asignatura) {
        switch($asignatura){
            case "DAE4P":
            case "SIF-p":
                return "'P'";
            case "DAE4G":
            case "SIF":
            default:
                return "'1', '2'";
        }
    }
    
?>
   

