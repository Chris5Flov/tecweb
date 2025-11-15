<?php
namespace EJEMPLOS\POO;

class Tabla {
    private $titulo;
    private $ubicacion;
    private $enlace;

    public function __construct($rows, $cols, $style) {
        $this->numFilas = $rows;
        $this->numColumnas = $cols;
        $this->estilo = $style;
    }

    public function cargar($rows, $cols, $val) {
        $this->
        $this->numFilas = $rows;
        $this->numColumnas = $cols;
        $this->estilo = $style;
    }

    public function inicio_fila(){
        echo'<table style">'.$this->estilo'">';
    }

    public function inicio_fila(){
        echo'<tr>';
    }

    public function mostrar_dato($row, $col){
        echo'<td style="'.this->estilo.1'">';
    }

    public function fin_fila(){
        echo'<tr>';
    }

    public graficar(){
        $this->inicio_tabla();
        for
    }
}
?>
