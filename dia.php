<?php
/**
 * Description of dia
 *
 * @author ruben
 */
class Dia {    
    public $fecha;
    public $diaSemana;
    public $festivo;
    public $vacaciones;
    public $horasClase;
    public $unidades;
    public $diaCursoCont;
    public $diaClaseCont;
    public $semanaCont;

    public function __construct($fecha) {
//        echo ">>>>>".$fecha->format('Y-m-d');
//        echo ">>>>> Dia semana ".$fecha->format('w');
        $this->fecha = $fecha;
        $this->diaSemana =  $this->fecha->format('w');
        $this->unidades = array(); // array porque podrian ser 2
        $this->horasClase = 0;
    }


    public function toString(){
        $texto = "<table>";
        $texto .= "<tr><td>Fecha = ".$this->fecha->format('Y-m-d')."</td></tr>";
        $texto .= "<tr><td>DiaSemana = ".$this->diaSemana."</td></tr>";
        $texto .= "<tr><td>Festivo = ".$this->festivo."</td></tr>";
        $texto .= "<tr><td>HorasClase = ".$this->horasClase."</td></tr>";
        $texto .= "<tr><td>DiaCurso = ".$this->diaCursoCont."</td></tr>";
        $texto .= "<tr><td>DiaClase = ".$this->diaClaseCont."</td></tr>";
        $texto .= "<tr><td>Semana = ".$this->semanaCont."</td></tr>";
        $texto .= "<tr><td>Unidades = ".$this->unidades[0]->Codigo." - ".$this->unidades[0]->Nombre."</td></tr>";
        $texto .= "</table>";
        return $texto;
    }
}
?>
