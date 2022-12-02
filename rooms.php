<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Připojení k DB</title>
</head>
<body class="container">
<h1>Seznam místností</h1>

<?php

require_once "db_connect.inc.php";

$sort = filter_input(INPUT_GET, 'poradi', FILTER_SANITIZE_STRING);
if (!$sort) {
    $STMTsort = $pdo->query("SELECT * FROM room");
}
if ($sort == "nazev_down") {
    $STMTsort = $pdo->query("SELECT * FROM room ORDER BY name DESC");
} else if ($sort == "cislo_down") {
    $STMTsort = $pdo->query("SELECT * FROM room ORDER BY no DESC");
} else if ($sort == "telefon_down") {
    $STMTsort = $pdo->query("SELECT * FROM room ORDER BY phone DESC");
} elseif ($sort == "nazev_up") {
    $STMTsort = $pdo->query("SELECT * FROM room ORDER BY name");
} else if ($sort == "cislo_up") {
    $STMTsort = $pdo->query("SELECT * FROM room ORDER BY no");
} else if ($sort == "telefon_up") {
    $STMTsort = $pdo->query("SELECT * FROM room ORDER BY phone");
}

if ($STMTsort->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
} else {
    echo "<table class='table'><tr><th>Název<a href='?poradi=nazev_up' class='sorted'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=nazev_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Číslo<a href='?poradi=cislo_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=cislo_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Telefon<a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th></tr>";
}
while ($row = $STMTsort->fetch()) {
    echo '<tr>';
    echo "<td><a href='room.php?roomId={$row->room_id}'>{$row->name}</a></td>";
    echo "<td>" . $row->no . "</td>";
    echo "<td>" . $row->phone . "</td>";
    echo "</tr>";
}

echo "</table>";
unset($stmt);

?>
</body>
</html>