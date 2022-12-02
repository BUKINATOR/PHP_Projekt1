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
    <link rel="stylesheet" href="style.css">
    <title>Seznam zaměstnanců</title>
</head>
<body class="container">
<h1>Seznam Zaměstnanců</h1>
<?php
require_once "db_connect.inc.php";
$sort = filter_input(INPUT_GET, 'poradi', FILTER_SANITIZE_STRING);
if (!$sort) {
    $STMTsort = $pdo->query("SELECT *  FROM room JOIN employee ON room = room_id");

}
if ($sort == "prijmeni_down") {
    $STMTsort = $pdo->query("SELECT *  FROM room JOIN employee ON room = room_id ORDER BY surname DESC");
} else if ($sort == "nazev_down") {
    $STMTsort = $pdo->query("SELECT * FROM room JOIN employee ON room = room_id  ORDER BY job DESC");
} else if ($sort == "pozice_down") {
    $STMTsort = $pdo->query("SELECT * FROM room JOIN employee ON room = room_id ORDER BY  wage DESC");
} else if ($sort == "telefon_down") {
    $STMTsort = $pdo->query("SELECT * FROM room JOIN employee ON room = room_id ORDER BY phone DESC");
} else if ($sort == "prijmeni_up") {
    $STMTsort = $pdo->query("SELECT * FROM room JOIN employee ON room = room_id ORDER BY surname ");
} else if ($sort == "nazev_up") {
    $STMTsort = $pdo->query("SELECT *  FROM room JOIN employee ON room = room_id  ORDER BY job ");
} else if ($sort == "pozice_up") {
    $STMTsort = $pdo->query("SELECT *  FROM room JOIN employee ON room = room_id ORDER BY  wage ");
} else if ($sort == "telefon_up") {
    $STMTsort = $pdo->query("SELECT *  FROM room JOIN employee ON room = room_id ON room = room_id ORDER BY phone ");
}

if ($STMTsort->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
} else {
    echo "<table class='table'><tr><th>Jméno<a href='?poradi=prijmeni_up' class='sorted'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=prijmeni_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Místnost<a href='?poradi=nazev_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=nazev_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Telefon<a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th><th>Pozice<a href='?poradi=pozice_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=pozice_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th></tr>";
}
while ($row = $STMTsort->fetch()) {
    echo "<tr>";
    echo "<td><a href='clovek.php?employee_id={$row->employee_id}'>" . htmlspecialchars($row->name) . " " . htmlspecialchars($row->surname) . "</a></td>";
    echo "<td>" . $row->wage . "</td>";
    echo "<td>" . $row->phone . "</td>";
    echo "<td>" . $row->job . "</td>";
    echo "</tr>";

}


unset($stmt);
echo "</table>";

?>
</body>
</html>