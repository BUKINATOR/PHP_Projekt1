<?php
$roomId = filter_input(
    INPUT_GET,
    'roomId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if (!$roomId) {
    http_response_code(400);
    echo "<h1>Bad request</h1>";
    die;
}


$roomId = filter_input(
    INPUT_GET,
    'roomId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);
require_once "db_connect.inc.php";

$queryAvg = "SELECT AVG(wage) AS AvgWage FROM employee INNER JOIN room ON employee.room = room.room_id WHERE room_id = ?";
$stmtAvg = $pdo->prepare($queryAvg);
$stmtAvg->execute([$roomId]);
$wageAvg = $stmtAvg->fetch(PDO::FETCH_OBJ);

$queryKeys = 'SELECT employee.name, employee.surname, employee.employee_id FROM ((`key` INNER JOIN room ON room.room_id=`key`.room) INNER JOIN employee ON `key`.employee = employee.employee_id) WHERE room_id = ?';
$stmtKeys = $pdo->prepare($queryKeys);
$stmtKeys -> execute([$roomId]);

$queryEmp = 'SELECT employee.name AS EmNa, employee.surname AS EmSu, employee.employee_id AS EmId FROM employee RIGHT JOIN room ON employee.room = room.room_id WHERE room_id = ?';
$stmtEmp = $pdo->prepare($queryEmp);
$stmtEmp -> execute([$roomId]);


$query = "SELECT * FROM `room` WHERE `room_id`=:roomId";
$stmt = $pdo->prepare($query);
$stmt->execute(['roomId' => $roomId]);

if ($stmt->rowCount() === 0) {
    http_response_code(404);
    echo "<h1>Not found</h1>";
    die;
}

$room = $stmt->fetch();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail místnosti <?php echo $room->no ?></title>
</head>
<body>
<?php

echo "<h1>Místnost č. {$room->no}</h1>";
echo "<div>Telefon: {$room->phone}</div>";
echo "<div>Název: {$room->name}</div>";
echo "<div>Číslo: {$room->no}</div>";
echo "<div>Lidé:</div>";
echo "<div>Klíče: </div>";
 while($keys = $stmtKeys -> fetch(PDO::FETCH_OBJ))
        {
            echo "<a href='clovek.php?employee_id={$keys->employee_id}'>".htmlspecialchars($keys->name)." ".htmlspecialchars($keys->surname)."</a>";
            echo "<br>";
        }
            echo "<h4>Lidé: </h4>";
        while($join = $stmtEmp->fetch(PDO::FETCH_OBJ))
        {
            echo "<a href='clovek.php?employee_id={$join->EmId}'>".htmlspecialchars($join->EmNa)." ".htmlspecialchars($join->EmSu)."</a>";
            echo "<br>";
        }
        echo "<br>";

    unset($stmtEmp);
    unset($stmtAvg);
    unset($stmt);

echo "<div><a href='rooms.php'> Zpět na seznam místností</a></div>";
?>
</body>
</html>
