<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Interfaz
 *
 * @author ruben
 */
class Interfaz {
    // Configuracion
    private $asignatura;
    
    // Dias procesador
    private $DIAS;
    private $UNIDADES;

    public function __construct($_asignatura, $_DIAS, $_UNIDADES) {
        $this->asignatura = $_asignatura;
        $this->DIAS = $_DIAS;
        $this->UNIDADES = $_UNIDADES;
    }

    /** NO Sigue el nombre! Imprime todos los dias!
     *
     * @param <type> $fechaInicio
     * @param <type> $fechaFin
     */
    public function printDiasByRango($fechaInicio, $fechaFin){
        echo "<h1>$this->asignatura : Programacion</h1>";
//        echo "<strong>FechaInicio = ".$fechaInicio->format('Y-m-d')."</strong>";
//        echo "<strong>FechaFin = ".$fechaFin->format('Y-m-d')."</strong>";
        echo "<h2> Unidades </h2>";
        $this->printUnidades();

        //echo "<h2> PLANIFICACION".count($this->DIAS)."</h2>";
        $mes = -1;
        foreach($this->DIAS as $dia){
            // parsear dia
            $mesDia = $dia->fecha->format('m');
            $diaSemana = $dia->fecha->format('w');

            // cambio de mes
            if ($mes != $mesDia){
                // cambio de mes
                  // fin mes
                if ($mes != -1){
                    echo "</table>\n";
                }

                  // nuevo mes
                $mes = $mesDia;
                $this->printCabeceraMes($dia);
                // rellenar hasta lunes
                if ($diaSemana != 0 ){
                    $relleno = $diaSemana;
                }else{
                    // es domingo cambio
                    $relleno = 7;
                }
                for ($d = 1; $d < $relleno; $d++ ){
                    echo "<td></td>\n";// hueco de dia vacio
                }
            }
            // cambio de semana
            if ($diaSemana == 1){
                echo "</tr>\n";
                echo "<tr>\n";
            }

            // cambio de unidad
            //<<

            // escribir dia
            $this->printDia($dia);
        }

    }

    private function printDia($dia){
        //echo "\t<td bgcolor='".$dia->unidades[0]->Color."'>";
        // COLOR + INFORMACION
        if ($dia->horasClase > 0){
            // Dia de clase
            echo "\t<td class='UD".$dia->unidades[0]->Codigo."'>";
            echo "\t<strong>".$dia->fecha->format('d')."</strong><br>\n";
            echo "$dia->horasClase h <br>";
            echo "UD ".$dia->unidades[0]->Codigo."<br>";
        } else if ($dia->festivo!=NULL){
            // festivo
            echo "\t<td class='Festivo'>";
            echo "\t<strong>".$dia->fecha->format('d')."</strong><br>\n";
        } else if ($dia->vacaciones!=NULL){
            // vacaciones
            echo "\t<td class='Vacaciones'>";
            echo "\t<strong>".$dia->fecha->format('d')."</strong><br>\n";
        } else if ($dia->diaSemana == 0 || $dia->diaSemana ==6 ){
            // Fin de semana
            echo "\t<td class='FinDeSemana'>";
            echo "\t<strong>".$dia->fecha->format('d')."</strong><br>\n";
        } else {
            // Dia laboral sin clase
            echo "\t<td class='UD".$dia->unidades[0]->Codigo."_noclase'>";
            echo "\t<strong>".$dia->fecha->format('d')."</strong><br>\n";
            echo "-<br>";
            echo "UD ".$dia->unidades[0]->Codigo."<br>";
        }
              
        echo "</td>\n";
    }
    private function printCabeceraMes($dia){
        $mes = $dia->fecha->format('m');
        $anyo = $dia->fecha->format('Y');
        echo "\t<h1>".$this->nombreMes($mes)." - ".$anyo."\n";
        echo "<table>\n";
        // cabecera mes
        echo "\t<theader><tr>\n";
            echo "\t<th>Lunes</th>\n";
            echo "\t<th>Martes</th>\n";
            echo "\t<th>Miercoles</th>\n";
            echo "\t<th>Jueves</th>\n";
            echo "\t<th>Viernes</th>\n";
            echo "\t<th>Sabado</th>\n";
            echo "\t<th>Domingo</th>\n";
        echo "\t</tr></theader>\n";

    }

    private function nombreMes($mes){
        switch($mes){
            case 1: return "Enero";
            case 2: return "Febrero";
            case 3: return "Marzo";
            case 4: return "Abril";
            case 5: return "Mayo";
            case 6: return "Junio";
            case 7: return "Julio";
            case 8: return "Agosto";
            case 9: return "Septiembre";
            case 10: return "Ocutubre";
            case 11: return "Noviembre";
            case 12: return "Diciembre";
            default : return "ERROR: nombreMes: Mes desconocido";
        }
    }


    public function printUnidades(){

        echo "<h1>Unidades Procesadas</h1>";
        echo "<table>";
        echo "<theader><th>Codigo</th><th>Unidad</th>
            <th>Duracion</th><th>Inicio</th><th>Fin</th>
            <th>Dias</th><th>Clase</th><th>Exceso</th></theader>";
        foreach($this->UNIDADES as $unidad){
            echo "<tr>";
            echo "<td>".$unidad->Codigo."</td>";
            echo "<td class='UD".$unidad->Codigo."'>".$unidad->Nombre."</td>";
            echo "<td>".$unidad->Duracion."</td>";
            if ($unidad->FechaInicio!= NULL){
               echo "<td>".$unidad->FechaInicio->format('Y-m-d')."</td>";
            } else{
                echo "<td>X</td>";
            }
            if ($unidad->FechaFin!= NULL){
                echo "<td>".$unidad->FechaFin->format('Y-m-d')."</td>";
            } else{
                echo "<td>X</td>";
            }

            echo "<td>".count($unidad->DIAS)."</td>";
            echo "<td>".$unidad->DiaUnidadCont."</td>";
            echo "<td>".$unidad->pendiente()."</td>";

            echo "</tr>";
        }
        echo "</table>";
    }
}
?>

