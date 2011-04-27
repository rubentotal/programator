<?php
/**
 * Description of Programator
 *
 * @author ruben
 */
require_once 'db/BD_conexion.php';
require_once 'dia.php';
require_once 'unidad.php';

class Programator {

    // Conectar con el servidor de base de datos
    private $BD;

    // Configuracion
    private $asignatura;
    private $horario;

    
    // Procesamiento
    private $diasCursoCont;
    private $diasClaseCont;
    private $semanaCont;

    // Dias procesador
    public $DIAS;
    public $UNIDADES;


    public function __construct() {
        $this->BD = new BD_conexion();
        $this->timeZone = new DateTimeZone("Europe/Paris");
        $this->DIAS = array();
        $this->UNIDADES = array();
    }

    /**
     *  Carga las horas de cada dia
     */

    public function programarDias($asignatura, $evaluaciones){
        $this->asignatura = $asignatura;
        //date_default_timezone_set('Europe/Madrid');

        // cargar dias de clase
        $this->cargarHorario($this->asignatura);

        // cargar unidades
        $this->cargarUnidades($this->asignatura);

        // inicializacion programator
        //$muerte = 0;
        $this->diasCursoCont = 0;
        $this->diasClaseCont = 0;
        $this->semanaCont = 0;
        $this->DIAS = array();

        // recorrer evaluaciones
        //$sql = "SELECT * FROM evaluaciones WHERE Codigo IN ('1','2')";
        $sql = "SELECT * FROM evaluaciones WHERE Codigo IN (".$evaluaciones.")";
        
        $result = $this->BD->consultar($sql);
        reset($this->UNIDADES); //inicializacion del recorrido de UNIDADES
       
        while ($evaluacion = $result->fetch_object()){
            echo "<h1>Evaluacion: ".$evaluacion->Codigo." </h1>";
            echo "<p>Inicio: ".$evaluacion->Inicio." </p>";
            echo "<p>Fin: ".$evaluacion->Fin." </p>";

                // inicializar dias
            $fecha = new DateTime($evaluacion->Inicio, $this->timeZone);
            $fin = new DateTime($evaluacion->Fin, $this->timeZone);

            // recorrer dias de evaluacion
            while ($fecha <= $fin ){ //&& $muerte<1000

                $dia = $this->procesarDia($fecha);                
                $this->DIAS[] = $dia; //anyadimos el dia a la lista
                                                                
                // iterar dia
                $fecha = clone $fecha;
                $fecha->add(new DateInterval('P1D')); //1D = 1 dia
                //$muerte++;

            }// fin evaluacion
            
            //echo "<h2>".count($this->DIAS)."</h2>";

        }// fin curso      
    }


    private function procesarDia($fecha){
        $dia = new Dia($fecha);        
        $this->esDiaClase($dia);
        $this->procesarContadores($dia);
        $this->asignarUnidades($dia);

        return $dia;
    }

    private function esDiaClase($dia){                
        // es festivo
        $sql = "SELECT * FROM festivos WHERE Fecha = '".$dia->fecha->format('Y-m-d')."'";
        $result = $this->BD->consultar($sql);        
        if ($result->num_rows >0 ){
            // Es festivo            
            $dia->festivo = $result->fetch_object();
            return;
        }

        // es vacaciones
        $sql = "SELECT * FROM vacaciones WHERE
            Inicio <= '".$dia->fecha->format('Y-m-d')."' AND
            Fin >= '".$dia->fecha->format('Y-m-d')."'";
        $result = $this->BD->consultar($sql);
        if ($result->num_rows >0 ){
            // Es vacaciones            
            $dia->vacaciones = $result->fetch_object();
            return;
        }

        // fin de semana
        if ($dia->diaSemana == 0 OR  $dia->diaSemana == 6 ){
            return;
        }

        $dia->horasClase = $this->horario[$dia->diaSemana];
               
        return;
    }


    private function procesarContadores($dia){
        // dia del curso
        $dia->diaCursoCont =  ++$this->diaCursoCont;

        // dia de clase
        if ( $dia->horasClase > 0 ){
            $dia->diaClaseCont =  ++$this->diaClaseCont;
        }

        // semana
        if ( $dia->diaSemana == 1 ){
            $dia->semanaCont =  ++$this->semanaCont;
        }

    }

    private function asignarUnidades($dia){        
        $horasPorAsignar = $dia->horasClase; // son las de la clase

        $unidad = current($this->UNIDADES);
        if ($unidad == NULL){
            // no quedan unidades por asignar
            return;
        }

        if($dia->horasClase == 0){
            // dia sin horas
            $dia->unidades[] = $unidad; // unidad que se imparte ese dia
            $unidad->asignarDia($dia, 0); // 0 horas
            return;
        }
        $muerte = 0;
        while ( $horasPorAsignar > 0 ){
            $dia->unidades[] = $unidad; // unidad que se imparte ese dia            
            if ($unidad->pendiente() > $dia->horasClase){
                $horasAsignadas = $dia->horasClase;
                $unidad->asignarDia($dia, $horasAsignadas);
                $horasPorAsignar -= $horasAsignadas; // entre todas las unidades
            } else{
                $horasAsignadas = $unidad->pendiente();
                $unidad->asignarDia($dia, $horasAsignadas);
                $horasPorAsignar -= $horasAsignadas; // entre todas las unidades

                // Iteramos a siguiente unidad
                next($this->UNIDADES);
                $unidad = current($this->UNIDADES);
                if ($unidad == NULL){
                    // no quedan unidades por asignar
                    return;
                }
            }                                   
        }// fin horasPorAsignar

    }


//    public function asignarHorasClase($dia){
//        echo "<br>AsignarHorasClase";
//        echo "<br>DiaSemana=".$dia->diaSemana;
//        echo "<br>Horas=".$this->horario[$dia->diaSemana];
//        $dia->horasClase = $this->horario[$dia->diaSemana];
//    }

    public function cargarHorario($asignatura){
        $sql = "SELECT * FROM horarios WHERE Asignatura =  '".$asignatura."' ORDER BY Dia ASC";
        $result = $this->BD->consultar($sql);
        $this->horario = array(0,0,0,0,0,0,0 ); // d l m x j v s

        while ($hora = $result->fetch_object()){            
            $this->horario[$hora->dia] = $hora->horas;
        }

//        echo "<h1>Horario</h1>";
//        foreach($this->horario as $hora){
//            echo "<p>".$hora."</p>";
//        }

    }


    public function cargarUnidades($asignatura){
        $sql = "SELECT * FROM unidades WHERE Asignatura =  '".$asignatura."' ORDER BY Codigo ASC";
        $result = $this->BD->consultar($sql);

        while ($unidad = $result->fetch_object('Unidad')){            
            $this->UNIDADES[] = $unidad;
        }

//        echo "<h1>Unidades</h1>";
//        foreach($this->UNIDADES as $unidad){
//            echo "<p>".$unidad->toString()."</p>";
//        }
    }



    public function printDias(){
        echo "<h1>Print Dias</h1>";
        echo "<h2>".count($this->DIAS)."</h2>";
        echo "<p>Num dias".count($this->DIAS)."</p>";
        foreach($this->DIAS as $dia){
            echo "<hr>";
            echo $dia->toString();
        }
    }


    public function printUnidades(){

        echo "<h1>Unidades Procesadas</h1>";
        foreach($this->UNIDADES as $unidad){
            echo "<hr>";
            echo "<p>".$unidad->toString()."</p>";

            echo "<table><tr>";
            foreach($unidad->DIAS as $dia){
                echo "<td>".$dia->diaCursoCont."</td>";
                echo "<td>".$dia->fecha->format('Y-m-d')."</td>";
            }
            echo "</tr></table>";
        }
        echo "<hr>";
    }
}
?>
