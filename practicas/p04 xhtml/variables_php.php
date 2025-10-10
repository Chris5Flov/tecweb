<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Título de la página</title>
  </head>

  <body>
    <h2>Manejo de variables en PHP</h2>

    <?php
      echo "<h2>Inciso 1. Variables válidas</h2>";
      echo '$_myvar: es válida, porque comienza con un guion bajo, sigue la nomenclatura de PHP<br />';
      echo '$_7var: es válida, porque comienza con un guion bajo, sigue la nomenclatura de PHP<br />';
      echo 'myvar: no es válida, porque no comienza con el signo de $, no sigue la nomenclatura de PHP<br />';
      echo '$myvar: es válida, porque comienza con el signo $, sigue la nomenclatura de PHP<br />';
      echo '$var7: es válida, porque comienza con el signo $, sigue la nomenclatura de PHP<br />';
      echo '$_element1: es válida, porque comienza con un guion bajo, sigue la nomenclatura de PHP<br />';
      echo '$house*5: no es válida, porque tiene un signo *, no sigue la nomenclatura de PHP<br />';
    ?>

    <?php
      echo "<h2>Inciso 2. Dar valores</h2>";
      echo "<h3>a)</h3>";
      $a = "ManejadorSQL";
      $b = "MySQL";
      $c = &$a;

      echo "Variable \$a: $a<br />";
      echo "Variable \$b: $b<br />";
      echo "Variable \$c: $c<br />";

      echo "<h3>b) y c)</h3>";
      $a = "PHP server";
      $b = &$a;

      echo "Variable \$a: $a<br />";
      echo "Variable \$b: $b<br />";
      echo "Variable \$c: $c<br />";

      echo "<h3>d)</h3>";
      echo "La variable \$a cambia su valor a 'PHP server' y como las variables \$b y \$c son referencias de \$a, toman el mismo valor.<br />";
    ?>

    <?php
      echo "<h2>Inciso 3. Mostrar contenido de variables después de la asignación.</h2>";
      $a = "PHP5";
      echo "Variable \$a: $a<br />";

      $z[] = &$a;
      echo "Arreglo \$z después de agregar \$a:<br />";
      echo "<pre>";
      print_r($z);
      echo "</pre>";

      $b = "5a versión de PHP";
      echo "Variable \$b: $b<br />";

      @$c = $b * 10;
      echo "Variable \$c: $c<br />";

      $a .= $b;
      echo "Variable \$a después de concatenar \$b: $a<br />";

      @$b *= $c;
      echo "Variable \$b después de multiplicar por \$c: $b<br />";

      $z[0] = "MySQL";
      echo "Arreglo \$z después de cambiar \$z[0]:<br />";
      echo "<pre>";
      print_r($z);
      echo "</pre>";

      unset($a, $b, $c, $z);
    ?>

    <?php
      echo "<h2>Inciso 4. Mostrar contenido de variables después de la asignación con \$GLOBALS</h2>";

      $GLOBALS['a'] = "PHP5";
      echo "Variable \$a: " . $GLOBALS['a'] . "<br />";
      $GLOBALS['z'][] = &$GLOBALS['a'];
      echo "Arreglo \$z:<br />";
      echo "<pre>";
      print_r($GLOBALS['z']);
      echo "</pre>";

      $GLOBALS['b'] = "5a versión de PHP";
      echo "Variable \$b: " . $GLOBALS['b'] . "<br />";

      @$GLOBALS['c'] = $GLOBALS['b'] * 10;
      echo "Variable \$c: " . $GLOBALS['c'] . "<br />";

      $GLOBALS['a'] .= $GLOBALS['b'];
      echo "Variable \$a después de concatenar \$b: " . $GLOBALS['a'] . "<br />";

      @$GLOBALS['b'] *= $GLOBALS['c'];
      echo "Variable \$b después de multiplicar por \$c: " . $GLOBALS['b'] . "<br />";

      $GLOBALS['z'][0] = "MySQL";
      echo "Arreglo \$z después de cambiar \$z[0]:<br />";
      echo "<pre>";
      print_r($GLOBALS['z']);
      echo "</pre>";

      unset($GLOBALS['a'], $GLOBALS['b'], $GLOBALS['c'], $GLOBALS['z']);
    ?>

    <?php
      echo "<h2>Inciso 5. Dar valor a variables \$a, \$b, \$c</h2>";

      $a = "7 personas";
      $b = (int) $a;
      $a = "9e3";
      $c = (float) $a;

      echo "Variable \$a: $a<br />";
      echo "Variable \$b: $b<br />";
      echo "Variable \$c: $c<br />";
    ?>

    <?php
      echo "<h2>Inciso 6. Comprobar valor booleano de variables</h2>";
      $a = "0";
      $b = "TRUE";
      $c = FALSE;
      $d = ($a OR $b);
      $e = ($a AND $c);
      $f = ($a XOR $b);

      echo "Variable \$a: "; var_dump($a); echo "<br />";
      echo "Variable \$b: "; var_dump($b); echo "<br />";
      echo "Variable \$c: "; var_dump($c); echo "<br />";
      echo "Variable \$d: "; var_dump($d); echo "<br />";
      echo "Variable \$e: "; var_dump($e); echo "<br />";
      echo "Variable \$f: "; var_dump($f); echo "<br />";
    ?>

    <?php
      echo "<h2>Transformación de valor booleano de las variables \$c y \$e</h2>";
      echo "Variable \$c: " . (int)$c . "<br />";
      echo "Variable \$e: " . (int)$e . "<br />";
    ?>

    <?php
      echo "<h2>Inciso 7: Uso de variable \$_SERVER</h2>";
      echo "Versión de Apache: " . $_SERVER['SERVER_SOFTWARE'] . "<br />";
      echo "Versión de PHP: " . phpversion() . "<br />";
      echo "Nombre del sistema operativo: " . PHP_OS . "<br />";
      echo "Idioma del navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br />";
    ?>
    <p>
        <a href="https://validator.w3.org/check?uri=referer"><img
        src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
    </p>
  </body>
</html>