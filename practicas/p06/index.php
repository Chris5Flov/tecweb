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

    <h2>Ejercicio 4</h2>
    <p>Arreglo de letras con ASCII</p>

    <?php
    function arregloAscii() {
        $b = [];
        for ($i = 97; $i <= 122; $i++) {
            $b[$i] = chr($i); 
        }
        return $b;
    }

    $arreglo = arregloAscii();

    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Índice</th><th>Letra</th></tr>";

    foreach ($arreglo as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>";
    }

    echo "</table>";
    ?>

    <h2>Ejercicio 5</h2>
    <p>Identificar sexo y edad</p>

    <form action="" method="post">
        Edad: <input type="text" name="edad" required><br>
        Sexo: <input type="text" name="sexo" required><br>
        <input type="submit" value="Verificar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $edad = $_POST['edad'];
        $sexo = strtolower(trim($_POST['sexo'])); // normaliza el texto

        if ($sexo === 'femenino' && $edad >= 18 && $edad <= 35) {
            echo "<p><strong>Bienvenida, usted está en el rango de edad permitido.</strong></p>";
        } else {
            echo "<p><strong>No cumple con los requisitos de edad y/o sexo.</strong></p>";
        }
    }
    ?>

    <h2>Ejercicio 6</h2>
    <p>Parque vehicular de una ciudad</p>

    <?php
    $parqueVehicular = [
        "ABC1234" => [
            "Auto" => [
                "marca" => "HONDA",
                "modelo" => 2020,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Alfonso Esparza",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "C.U., Jardines de San Manuel"
            ]
        ],
        "XYZ5678" => [
            "Auto" => [
                "marca" => "MAZDA",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "María Molina",
                "ciudad" => "Puebla, Pue.",
                "direccion" => "97 Oriente"
            ]
        ],
        "JKL8901" => [
            "Auto" => [
                "marca" => "TOYOTA",
                "modelo" => 2021,
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Carlos Ramírez",
                "ciudad" => "CDMX",
                "direccion" => "Av. Reforma 100"
            ]
        ],
        "QWE4321" => [
            "Auto" => [
                "marca" => "NISSAN",
                "modelo" => 2018,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Laura Sánchez",
                "ciudad" => "Guadalajara, Jal.",
                "direccion" => "Col. Americana 23"
            ]
        ],
        "LMN6543" => [
            "Auto" => [
                "marca" => "FORD",
                "modelo" => 2022,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Ricardo López",
                "ciudad" => "Monterrey, NL",
                "direccion" => "San Pedro Garza García"
            ]
        ],
        "RTY8765" => [
            "Auto" => [
                "marca" => "KIA",
                "modelo" => 2021,
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Ana Torres",
                "ciudad" => "Querétaro, Qro.",
                "direccion" => "Av. Universidad 500"
            ]
        ],
        "FGH1357" => [
            "Auto" => [
                "marca" => "CHEVROLET",
                "modelo" => 2017,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Jorge Fernández",
                "ciudad" => "Toluca, Edo. Méx.",
                "direccion" => "Col. Centro 12"
            ]
        ],
        "UIO2468" => [
            "Auto" => [
                "marca" => "VOLKSWAGEN",
                "modelo" => 2019,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Patricia Méndez",
                "ciudad" => "León, Gto.",
                "direccion" => "Blvd. Aeropuerto 300"
            ]
        ],
        "BNM9753" => [
            "Auto" => [
                "marca" => "HYUNDAI",
                "modelo" => 2020,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Luis Gómez",
                "ciudad" => "Mérida, Yuc.",
                "direccion" => "Centro Histórico 45"
            ]
        ],
        "POI8642" => [
            "Auto" => [
                "marca" => "MITSUBISHI",
                "modelo" => 2016,
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Fernanda Ruiz",
                "ciudad" => "Cancún, Q. Roo",
                "direccion" => "Zona Hotelera 200"
            ]
        ],
        "VBN3579" => [
            "Auto" => [
                "marca" => "TESLA",
                "modelo" => 2023,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Diego Martínez",
                "ciudad" => "CDMX",
                "direccion" => "Polanco 110"
            ]
        ],
        "ASD7412" => [
            "Auto" => [
                "marca" => "BMW",
                "modelo" => 2021,
                "tipo" => "camioneta"
            ],
            "Propietario" => [
                "nombre" => "Gabriela Ortiz",
                "ciudad" => "Tijuana, BC",
                "direccion" => "Zona Río 34"
            ]
        ],
        "GHJ8523" => [
            "Auto" => [
                "marca" => "MERCEDES",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Héctor Hernández",
                "ciudad" => "Saltillo, Coah.",
                "direccion" => "Col. Roma 10"
            ]
        ],
        "KLM9634" => [
            "Auto" => [
                "marca" => "AUDI",
                "modelo" => 2020,
                "tipo" => "hatchback"
            ],
            "Propietario" => [
                "nombre" => "Marisol Vargas",
                "ciudad" => "Pachuca, Hgo.",
                "direccion" => "Zona Centro 99"
            ]
        ],
        "ZXC1597" => [
            "Auto" => [
                "marca" => "PEUGEOT",
                "modelo" => 2018,
                "tipo" => "sedan"
            ],
            "Propietario" => [
                "nombre" => "Rodrigo Silva",
                "ciudad" => "Oaxaca, Oax.",
                "direccion" => "Av. Juárez 123"
            ]
        ]
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['matricula'])) {
        $matricula = strtoupper(trim($_POST['matricula']));

        echo "<pre>";
        if ($matricula === "TODOS") {
            print_r($parqueVehicular);
        } elseif (array_key_exists($matricula, $parqueVehicular)) {
            print_r($parqueVehicular[$matricula]);
        } else {
            echo "No se encontró el vehículo con matrícula: $matricula";
        }
        echo "</pre>";
    }
    ?>

    <form action="" method="post">
        <label for="matricula">Ingresa matrícula (o todos los autos registrados): </label>
        <input type="text" id="matricula" name="matricula" required>
        <input type="submit" value="Consultar">
    </form>

</body>
</html>

