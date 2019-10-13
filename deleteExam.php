<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = "sql1.njit.edu";
$user = "tpp26";
$dbPassword = "hp8pCxxm";
$db = "tpp26";

$id=$_POST["id"];
$grade=$_POST["grade"];

$conn = mysqli_connect($host, $user, $dbPassword, $db);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$sql="TRUNCATE TABLE `exam`";
$query = $conn->query($sql);

if($query){
  $stuff->Operation = "success";
  $stuffJson = json_encode($stuff);
  echo $stuffJson;
}
else{
  $stuff->Operation = "fail";
  $stuffJson = json_encode($stuff);
  echo $stuffJson;
}


$conn->close();

?>