<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Unidad
 *
 * @author ruben
 */
class Unidad {
    // Tabla
    public $Asignatura;
    public $Codigo;
    public $Nombre;
    public $Descripcion;
    public $Duracion;
    public $Color;
    // Procesamiento
    public $Asignado;
    public $DiaUnidadCont = 0;
    public $FechaInicio;
    public $FechaFin;

    // Relacionado
    public $DIAS;

    public function __construct() {
        $DIAS = array();
        $this->Asignado = 0;
    }

    public function pendiente(){
        return $this->Duracion-$this->Asignado;
    }

    /** Las horas asignadas pueden no ser todas las del dia
     * (dias sin docencia / dias de cambio de unidad)
     * @param <type> $dia
     * @param <type> $horas
     * @return <type>
     */
    public function asignarDia($dia, $horas){
        $this->DIAS[] = $dia;

        if ($horas > 0){
            $this->DiaUnidadCont++;
        }
        if ($this->DiaUnidadCont==1){
            //echo "<< ";
            $this->FechaInicio = clone $dia->fecha;
        }       

        $this->Asignado += $horas;
        if ($this->pendiente()==0){
            $this->FechaFin = clone $dia->fecha;
        }
    }

    public function toString(){
        $texto = "<table>";
        $texto .= "<tr><td>Asignatura = ".$this->Asignatura."</td></tr>";
        $texto .= "<tr><td>Codigo = ".$this->Codigo."</td></tr>";
        $texto .= "<tr><td>Nombre = ".$this->Nombre."</td></tr>";
        $texto .= "<tr><td>Descripcion = ".$this->Descripcion."</td></tr>";
        $texto .= "<tr><td>Duracion = ".$this->Duracion."</td></tr>";
        $texto .= "<tr><td>Asignado = ".$this->Asignado."</td></tr>";
        if ($this->FechaInicio!= NULL){
            $texto .= "<tr><td>FechaInicio = ".$this->FechaInicio->format('Y-m-d')."</td></tr>";
        }
        if ($this->FechaFin!= NULL){
            $texto .= "<tr><td>FechaFin = ".$this->FechaFin->format('Y-m-d')."</td></tr>";
        }
        $texto .= "</table>";
        return $texto;
    }

}
?>
