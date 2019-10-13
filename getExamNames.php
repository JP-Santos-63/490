<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = "sql1.njit.edu";
$user = "tpp26";
$dbPassword = "hp8pCxxm";
$db = "tpp26";

$conn = mysqli_connect($host, $user, $dbPassword, $db);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo 'Connected to the database.';

$result = mysqli_query($conn, "SELECT * FROM exam");

$items=[];
while ($row = mysqli_fetch_row($result)) {  
    if (!in_array($row[0], $items)) {
        $items[]=$row[0];
    }
}

echo json_encode($items);

//$stuffJson = json_encode($items);
//echo $stuffJson;

//$ayy = json_decode($stuffJson, true);
//print_r($ayy);

$conn->close();

?>
