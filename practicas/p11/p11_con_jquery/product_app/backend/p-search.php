<?php
    include_once __DIR__.'/database.php';

    $data = array();
    if( isset($_GET['search']) ) {
        $search = $_GET['search'];
        
        // MODIFICACIÓN: La consulta ahora busca SÓLO en la columna 'nombre'
        // coincidencias que inicien con el término de búsqueda.
        $sql = "SELECT * FROM productos WHERE nombre LIKE '{$search}%' AND eliminado = 0";

        if ( $result = $conexion->query($sql) ) {
            // RESULTADOS
			$rows = $result->fetch_all(MYSQLI_ASSOC);

            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $data[$num][$key] = utf8_encode($value);
                    }
                }
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    } 
    
    echo json_encode($data, JSON_PRETTY_PRINT);
?>