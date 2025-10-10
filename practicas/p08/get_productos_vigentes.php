<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
    if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];
    } else {
        die('Parámetro "tope" no detectado...');
    }

    if (!empty($tope)) {
        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', '12345678a', 'marketzone', 3399);

        /** comprobar la conexión */
        if ($link->connect_errno) {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
            /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
        }

        /** Crear una tabla que no devuelve un conjunto de resultados */
        if ($result = $link->query("SELECT * FROM productos WHERE unidades <= $tope AND eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            /** útil para liberar memoria asociada a un resultado con demasiada información */
            $result->free();
        }

        $link->close();
    }
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Productos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>img {
            width: 150px;        /* ancho deseado */
            height: 150px;       /* alto deseado */
            object-fit: cover;   /* recorta la imagen para mantener proporción */
            border-radius: 5px;  /* opcional, bordes redondeados */}
        </style>
    </head>
    <body>
        <h3>PRODUCTO</h3>

        <br/>

        <?php if(isset($rows) && count($rows) > 0) : ?>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Imagen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['marca'] ?></td>
                            <td><?= $row['modelo'] ?></td>
                            <td><?= $row['precio'] ?></td>
                            <td><?= $row['unidades'] ?></td>
                            <td><?= utf8_encode($row['detalles']) ?></td>
                            <td><img src="<?= $row['imagen'] ?>" alt="<?= $row['nombre'] ?>"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif(!empty($tope)) : ?>

            <script>
                alert('No hay productos con unidades menores o iguales');
            </script>

        <?php endif; ?>
    </body>
</html>