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
        <style><img {
            width: 300px;
            height: 300px;
            object-fit: cover;
        }
        </style>
        <script>
            function show() {
            // Obtener la fila en la que se hizo clic
                var row = event.target.closest("tr");
                var id = row.querySelector("th").innerHTML;

            // Obtener los datos de la fila
                var data = row.querySelectorAll(".row-data");

                var nombre = data[0].innerText;
                var marca = data[1].innerText;
                var modelo = data[2].innerText;
                var precio = data[3].innerText;
                var unidades = data[4].innerText;
                var detalles = data[5].innerText;
                var img = data[6].firstChild.getAttribute('src');


            alert("Nombre: " + nombre + "\nMarca: " + marca + "\nModelo: " + modelo + "\nPrecio: " + precio
                + "\nUnidades: " + unidades + "\nDetalles: " + detalles + "\nImagen: " + img);

                send2form(id, nombre, marca, modelo, precio, unidades, detalles, img);

            }
            
            function send2form(id, nombre, marca, modelo, precio, unidades, detalles, img ) {     //form) { 
                var urlForm = "formulario_productos_v2.php";
                var propId = "id="+id;
                var propNombre = "nombre="+nombre;
                var propMarca = "marca="+marca;
                var propModelo = "modelo="+modelo;
                var propPrecio = "precio="+precio;
                var propUnidades = "unidades="+unidades;
                var propDetalles = "detalles="+detalles;
                var propImagen = "imagen="+img;
                window.open(urlForm+"?"+propId+"&"+propNombre+"&"+propMarca+"&"+propModelo+"&"+propPrecio+"&"+propUnidades+"&"+propDetalles+"&"+propImagen);
                }
            
        </script>
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
                        <th scope="col">Modificacion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td class="row-data"><?= $row['nombre'] ?></td>
                            <td class="row-data"><?= $row['marca'] ?></td>
                            <td class="row-data"><?= $row['modelo'] ?></td>
                            <td class="row-data"><?= $row['precio'] ?></td>
                            <td class="row-data"><?= $row['unidades'] ?></td>
                            <td class="row-data"><?= utf8_encode($row['detalles']) ?></td>
                            <td class="row-data"><img src="<?= $row['imagen'] ?>" alt="<?= $row['nombre'] ?>" width="100"></td>
                            <td class="row-data"><input type="button" value="submit" onclick="show()" ></td>
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