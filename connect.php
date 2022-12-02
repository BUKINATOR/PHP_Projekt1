<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Připojení k DB</title>
</head>
<body class="container">
<?php
$host = '127.0.0.1';
$db = 'ip_3';
$user = 'www-aplikace';
$pass = 'Bezpe4n0Heslo.';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

$stmt = $pdo->query('SELECT room_id, name, no, phone FROM room ORDER BY no');

if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
}
else
{
    echo "<table class='table table-striped'>";
    echo "<tr><th>Name</th><th>No.</th><th>Phone</th></tr>";
    while ($row = $stmt->fetch()) { //nebo foreach ($stmt as $row)
        echo "<tr>";
//        echo "<td>{$row['name']}</td>";
//        echo "<td>{$row['no']}</td>";
//        echo "<td>{$row['phone']}</td>";
        echo "<td>{$row->name}</td>";
        echo "<td>{$row->no}</td>";
        echo "<td>{$row->phone}</td>";
        echo "</tr>";
//        var_dump($row);
    }
    echo "</table>";
}
unset($stmt);

?>
</body>
</html>