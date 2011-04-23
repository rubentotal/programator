<?php
/**
 * Description of BD_conexion
 *  Metodos de acceso a BD
 *
 * @author ruben
 */
class BD_conexion {
    protected $mysqli;


    /**
     *
     * @param <type> $servidor
     * @param <type> $usuario
     * @param <type> $password
     * @param <type> $bbdd
     * @return <conexion a tabla> $conexion : conexion establecida con la base de datos del
     *                 servidor especificado con el usuario/password indicado
     */
//    function __construct($servidor, $usuario, $password, $bbdd) {
//        $this->mysqli = new mysqli($servidor, $usuario, $password, $bbdd);
//
//        if ($this->mysqli->connect_errno) {
//            die('Connect Error: '.$mysqli->connect_errno);
//        }
//    }

    /** Incializa la base de datos por defecto
     *
     */
    public function __construct() {
        $servidor_BD = 'localhost';
        $usuario_BD = 'programator';
        $password_BD = 'programator';
        $nombre_BD = 'programator';
        $this->mysqli = new mysqli($servidor_BD, $usuario_BD, $password_BD, $nombre_BD);

        if ($this->mysqli->connect_errno) {
            die('Connect Error: '.$mysqli->connect_errno);
        }
    }

    public function __destruct() {
        $this->cerrar();
    }    

    /** Devuelve resource con el resultado de la consulta
     *
     * @param <type> $conexion : conexion establecida con la base de datos del
     *              servidor especificado con el usuario/password indicado
     * @param <type> $consulta
     * @return <type> resource con el resultado de la consulta
     */
    public function consultar ($consulta){
        $result = $this->mysqli->query($consulta);
        if ($this->mysqli->errno){
            // se ha producido un erro en la consulta
            echo "ERROR:".$this->mysqli->errno;
        }
        return $result;
    }

    /** Escribe con print la tabla correspondiente a la
     * Si el result esta vacio no escribe html
     * @param <type> $sql: sqk
     * @param <type> $liberar : al acabar libera la memoria del result
     * @return <type>
     */
    public function escribir_consulta ($sql, $liberar = null){
        $result = $this->consultar($sql);
        //echo "filas = ".$result->num_rows;
        echo $this->escribir_consulta_html($result, $liberar);
    }

    /** Devuelve una variable con texto html con generación de la tabla
     * correspondiente al resource de una consulta de BD. No escribe nada en la web.
     * Si el result esta vacio devuelve html vacío
     * @param <type> $result
     * @param <type> $liberar : al acabar libera la memoria del result
     * @return <type>
     */
    private function escribir_consulta_html ($result, $liberar = null){
        if (!$result){
            // ninguna fila
            return;
        }
        
        if ($result->num_rows > 0){
            // Si hay filas

            // cabecera de la tabla
            $consulta_html .= "<table>\n";
            $consulta_html .= "<tr>\n";

            $fila = $result->fetch_assoc();
            foreach ( $fila as $nombre => $valor){
                $consulta_html.= "<th>".$nombre."</th>\n";
            }
            $consulta_html .= "</tr>\n";

            // Mientra haya filas
            do{                
                // Escribir campos de fila
                $consulta_html .= "<tr>\n";
                foreach ( $fila as $nombre => $valor) {
                    $consulta_html .= "<td>" . $valor . "</td>\n";
                }
                $consulta_html .= "</tr>\n";
            }
            while ($fila = $result->fetch_assoc());
            $consulta_html .= "</table>\n";
        }

        // liberar memoria
        if (isset($liberar) && $liberar){
            $result->free();
        }

        return $consulta_html;
    }

     /** Cerrar conexión
     *
     * @param <type> $conexion
     */
    public function liberar_result($result){
        // Cerrar conexion
        if ($result != NULL){
            $result->free();
        }
    }

    /** Cerrar conexión
     *
     * @param <type> $conexion
     */
    public function cerrar (){
        // Cerrar conexion
        if ($this->mysqli != NULL){
            $this->mysqli->close();
        }        
    }


    //-------------------------------------

    /** Carga un registro de una tabla por el ID
     *
     * @param <type> $conexion
     */
    public function cargarRegistro($tabla, $ID){
        //Obtener registro
        $consulta = "SELECT * FROM $tabla WHERE ID ='$ID'";        
        $result = $this->consultar ($consulta);
        if (!$result || $result->num_rows <= 0){
            // ninguna fila
            return NULL;
        }

        // cargar
        $registro = $result->fetch_object();        
        return $registro;
    }


    public function cargarPropietario($ID){
        return $this->cargarRegistro("Propietarios", $ID);
    }

    public function cargarArticulo($ID){
        return $this->cargarRegistro("Articulos", $ID);
    }

    public function mostrarRegistro($tabla, $ID){
        // Obtener registro
        $obj = $this->cargarRegistro($tabla, $ID);
        if (obj == NULL){
            return NULL;
        }
        
        // Crear html
        $registro_html = "<table>";
        foreach ($obj as $key => $val) {
            $registro_html .= "<tr><th>$key</th><td> $val </td></tr>";
        }
        $registro_html .= "</table>";
        return $registro_html;
    }

    public function mostrarPropietario($ID){
        return $this->mostrarRegistro("Propietarios", $ID);
    }





    // --------------------------------------------
    //  CREACION DE OBJETOS HTML
    /** Genera un select de html () con el nombre del campo de una tabla.
     * El valro del select se coger� de la columna valor indicada
     *
     * @param <type> $name nombre del componente html generado
     * @param <type> $tabla
     * @param <type> $campo
     * @param <type> $valor
     * @return <type>
     */
    public function cargar_html_select($name, $tabla, $columna_nombre, $columna_valor){
        $consulta = "SELECT DISTINCT $columna_nombre, $columna_valor FROM $tabla ";        
        $result = $this->consultar($consulta);

        if (!$result || $result->num_rows <= 0){
            // ninguna fila
            return;
        }
        
        // Si hay filas

        // cabecera de la tabla
        $select_html .= "<select name=".$name." >\n";
        while($fila = $result->fetch_array()){
            $select_html .= '<option value="'.$fila[$columna_valor].'">'.$fila[$columna_nombre].'</option>\n';
        }
        $select_html .= "</select>\n";

        // liberar memoria
        if (isset($liberar) && $liberar){
            $result->free();
        }
        
        return $select_html;
    }
}

?>
