<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <form method="get">
    <label>Escribe un número: </label>
    <input type="number" name="numero" required>
    <button type="submit">Comprobar</button>
    </form>
    <?php
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            if ($num%5==0 && $num%7==0)
            {
                echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
            }
            else
            {
                echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
            }
        }
    ?>
    <h2>Ejercicio 2</h2>
    <p>Generación repetitiva de 3 números aleatorios hasta obtener una secuencia</p>
    <?php
        function secuencia() {
            $matriz = [];
            $iteracion = 0;
            $numgenerado = 0;

            while (true) {
                $f = [
                    rand(1, 999), 
                    rand(1, 999), 
                    rand(1, 999)
                ];

                $numgenerado += 3;
                $iteracion++;

                $matriz[] = $f;

                if ($f[0] % 2 != 0 && $f[1] % 2 == 0 && $f[2] % 2 != 0) {
                    break;
                }
            }

            return [$matriz, $iteracion, $numgenerado];
        }
        list($matriz, $iteracion, $numgenerado) = secuencia();
        echo "<table border='1' cellpadding='5'>";
        foreach ($matriz as $f) {
            echo "<tr><td>" . implode("</td><td>", $f) . "</td></tr>";
        }
        echo "</table>";
        echo "$numgenerado números generados en $iteracion iteraciones realizadas";
    ?>
    <h2>Ejercicio 3</h2>
    <p>Número múltiplo aleatorio con while y do while</p>

    <h2>Con ciclo while</h2>
    <?php
    function multiploAleatorioWhile($multiplo){
        $num = rand(1, 1000);
        while ($num % $multiplo != 0) {
            $num = rand(1, 1000);
        }
        return $num;
    }

    if (isset($_GET['multiplo'])) {
        $multiplo = $_GET['multiplo'];
        if (is_numeric($multiplo) && $multiplo > 0) {
            $resultado = multiploAleatorioWhile($multiplo);
            echo "El primer múltiplo de $multiplo encontrado con while es <strong>$resultado</strong>";
        }
    }
    ?>

    <h2>Con ciclo do while</h2>
    <?php
    function multiploAleatorioDoWhile($multiplo){
        do {
            $num = rand(1, 1000);
        } while ($num % $multiplo != 0);
        return $num;
    }

    if (isset($_GET['multiplo'])) {
        $multiplo = $_GET['multiplo'];
        if (is_numeric($multiplo) && $multiplo > 0) {
            $resultado = multiploAleatorioDoWhile($multiplo);
            echo "<br>El primer múltiplo de $multiplo encontrado con do while es <strong>$resultado</strong>";
        }
    }
    ?>

</body>
</html>

