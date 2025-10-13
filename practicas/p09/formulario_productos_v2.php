<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de productos</title>
    <style type="text/css">
        ol, ul { 
            list-style-type: none;
        }
    </style>
</head>
<body>
    <h1>Registro de productos</h1>
    <form id="formularioSuplementos" method="post" action="update_producto.php" onsubmit="return validarFormulario()">
        <fieldset>
            <legend>Agrega el producto</legend>
            <ul>
                <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <li><label for="form-name">Nombre: </label> <input type="text" name="nombre" id="form-name" value="<?= !empty($_POST['nombre'])?$_POST['nombre']:$_GET['nombre'] ?>"></li>
                <li>
                    <label for="form-marca">Marca:</label> 
                    <select name="marca" id="form-marca" required>
                        <option value="">Seleccione una marca</option>
                        <option value="Adidas" <?= !empty($_POST['marca'])?$_POST['marca']:$_GET['marca'] ?>>Adidas</option>
                        <option value="Nike" <?= !empty($_POST['marca'])?$_POST['marca']:$_GET['marca'] ?>>Nike</option>
                        <option value="Puma" <?= !empty($_POST['marca'])?$_POST['marca']:$_GET['marca'] ?>>Puma</option>
                        <option value="Pirma" <?= !empty($_POST['marca'])?$_POST['marca']:$_GET['marca'] ?>>Pirma</option>
                    </select>
                </li>
                <li><label for="form-modelo">Modelo: </label> <input type="text" name="modelo" id="form-modelo" value="<?= !empty($_POST['modelo'])?$_POST['modelo']:$_GET['modelo'] ?>"></li>
                <li><label for="form-precio">Precio: </label> <input type="number" name="precio" id="form-precio" step="0.01" value="<?= !empty($_POST['precio'])?$_POST['precio']:$_GET['precio'] ?>"></li>
                <li><label for="form-story">Ingresa los detalles del producto: </label><br><textarea name="story" rows="4" cols="60" id="form-story" ><?= !empty($_POST['detalles'])?$_POST['detalles']:$_GET['detalles'] ?></textarea></li>
                <li><label for="form-cantidad">Unidades: </label> <input type="number" name="cantidad" id="form-cantidad" value="<?= !empty($_POST['unidades'])?$_POST['unidades']:$_GET['unidades'] ?>"></li>
                <li><label for="form-imagen">Imagen:</label> <input type="text" name="imagen" id="form-imagen" placeholder="img/nombre-imagen.png" value="<?= !empty($_POST['imagen'])?$_POST['imagen']:$_GET['imagen'] ?>"></li>
            </ul>
        </fieldset>               
        <p>
            <input type="submit" value="Actualizar">
            <input type="reset">
        </p>
    </form>
    <script>
        function validarFormulario() {
            var nombre = document.getElementById('form-name').value.trim();
            var marca = document.getElementById('form-marca').value;
            var modelo = document.getElementById('form-modelo').value.trim();
            var precio = document.getElementById('form-precio').value;
            var cantidad = document.getElementById('form-cantidad').value;
            var imagenInput = document.getElementById('form-imagen');

            if (nombre === "" || nombre.length > 100) {
                alert("Debes ingresar el nombre y que tenga hasta 100 caracteres");
                return false;
            }

            if (marca === "") {
                alert("Selecciona una marca");
                return false;
            }

            if (!/^[a-zA-Z0-9 ]{1,25}$/.test(modelo)) {
                alert("El modelo no puede pasar de 25 caracteres");
                return false;
            }

            if (precio === "" || parseFloat(precio) < 99.99) {
                alert("Es necesario el precio y que sea mayor a 99.99");
                return false;
            }

            if (cantidad === "" || parseInt(cantidad) < 1) {
                alert("Debe haber al manos 1 unidad");
                return false;
            }

            if (imagenInput.value.trim() === '') {
                imagenInput.value = 'img/default.png';
            }
            return true;
        }
    </script>
</body>
</html>