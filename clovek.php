<?php
$emp_id = $_GET['employee_id'];
$emp_id = filter_input(INPUT_GET,"employee_id",FILTER_VALIDATE_INT);
require_once "db_connect.inc.php";

$query = 'SELECT employee.wage, employee.name,employee.surname,employee.job, room.name AS RoomName, room.room_id FROM employee INNER JOIN room ON room.room_id = employee.room WHERE employee.employee_id = ?';
$query2 = 'SELECT room.name AS RName, room.room_id AS RiD FROM 
    ((room INNER JOIN `key` ON room.room_id=`key`.room) 
    INNER JOIN employee ON employee.employee_id = `key`.employee) WHERE `key`.employee = ?';
if(!$emp_id)
{
    $state = "bad request";
    http_response_code(400);
    die("Error 400: Bad Request");
}
$stmt2 = $pdo->prepare($query2);
$stmt2  ->execute([$emp_id]);
$stmt = $pdo->prepare($query);
$stmt ->execute([$emp_id]);
$emp2 = $stmt2->fetch(PDO::FETCH_OBJ);
$emp = $stmt->fetch(PDO::FETCH_OBJ);
if($stmt2-> rowCount()==0||$stmt->rowCount()==0)
{
    die("Error 404: Not Found");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail místnosti <?php echo $emp->no ?></title>
</head>
<body>
<?php

echo "<h1>Karta Osoby: {$emp->name} {$emp->surname}</h1>";
echo "<div>Jméno: {$emp->name}</div>";
echo "<div>Příjmení: {$emp->surname}</div>";
echo "<div>Pozice: $emp->job</div>";
echo "<div>"."Mzda:  ".number_format($emp->wage,2,",",".")."</div>";
echo "<div>"."Místnost: "."<a href ='room.php?room_id={$emp->room_id}'>".htmlspecialchars($emp->RoomName)."</a>"."</div>";
echo "<div>Klíče: </div>";
while($emp2 = $stmt2->fetch(PDO::FETCH_OBJ))
{
    echo "<a href='room.php?roomId={$emp2->RiD}'>".htmlspecialchars($emp2->RName)."</a>";
    echo "<br>";
}
echo "<br>";

echo "<div><a href='rooms.php'>Zpět na seznam místností</a></div>";
?>
</body>
</html>