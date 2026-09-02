<?php 

session_start();

$_SESSION ["Registros"] ??= "";

$videojuegos = [
    #nombre => [categoria, precio, max jugadores]
    "Pelea juego 67" => ["Pelea",2,20],
    "Carreras 68" => ["Carreras",2.5,10],
    "Smash" => ["pelea",3,10]
];

$modalidades = ["Presencial","Virtual"];

$experiencias = ["poca","media","mucha"];

function determinar_categoria_edad(int $edad): string
{
    $categoria = "";

    if($edad < 12){
        $categoria = "infantil";
    }elseif($edad > 20){
        $categoria = "adolescente";
    }else{
        $categoria = "adulto";
    }
    return $categoria;
}

if($_SERVER["RequestMethod"] === "POST"){
    $nombre = trim($_POST["nombre"]);
    $edad = $_POST["edad"];
    $correo = trim($_POST["correo"]);
    $categoria_edad = determinar_categoria_edad($edad);
    $videojuego = $videojuegos[$_POST["juego"]];
    $modalidad = $_POST["modalidad"];
    $experiencia = $_POST["experiencia"];

    $descuento = $experiencia==="poca" ? 0.9 : 1;
    $precio = $videojuego[1]*$descuento;

    $_SERVER["Registro"][] = [
        "nombre"=> $nombre,
        "edad" => $edad,
        "correo" => $correo,
        "juego" => $videojuego,
        "modalidad" => $modalidad,
        "experiencia" => $experiencia,
        "cedad" => $categoria_edad,
        "precio" => $precio,
    ];

     header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcial 1</title>
</head>
<body>
    <form method="POST">
        <label>nombre</label>
        <input type="text" name="nombre" required>
        <label>edad</label>
        <input type="number" name="edad" required>
        <label>correo</label>
        <input type="text" name="correo" required>
        <select name="juego">
            <?php foreach($videojuegos as $key => $value ): ?>
                <option value="<?= $key ?>"> <?= $key." ".$value[1] ?> </option>
            <?php endforeach; ?>
        </select>
        <select name="modalidad">
            <?php foreach($modalidades as $value): ?>
                <option value="<?= $value ?>"> <?= $value ?> </option>
            <?php endforeach; ?>
        </select>
        <select name="experiencia">
            <?php foreach($experiencias as $value): ?>
                <option value="<?= $value ?>"> <?= $value ?> </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Inscribirse</button>
    </form>
    <table>
        <thead>
            <th>nombre</th>
            <th>edad</th>
            <th>correo</th>
            <th>juego</th>
            <th>modalidad</th>
            <th>experiencia</th>
            <th>categoria de edad</th>
            <th>precio</th>
        </thead>
        <tbody>
            <?php foreach($_SERVER["Registros"] as $registro => $value):  ?>
                <tr>
                    <td><?= $value["nombre"] ?></td>
                    <td><?= $value["edad"] ?></td>
                    <td><?= $value["correo"] ?></td>
                    <td><?= $value["juego"] ?></td>
                    <td><?= $value["modalidad"] ?></td>
                    <td><?= $value["experiencia"] ?></td>
                    <td><?= $value["cedad"] ?></td>
                    <td><?= $value["precio"] ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</body>
</html>