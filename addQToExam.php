<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = "sql1.njit.edu";
$user = "tpp26";
$dbPassword = "hp8pCxxm";
$db = "tpp26";

$name=$_POST["name"];
$id=$_POST["id"];
$q=$_POST["question"];
$desc=$_POST["description"]; 

$conn = mysqli_connect($host, $user, $dbPassword, $db);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//if (isset($_POST["arg2"]) && !empty($_POST["arg2"])){
$sql="INSERT INTO `tpp26`.`exam` (`name`, `id`, `question`, `description`, `args`, `tests`, `points`, `answer`, `grade`) VALUES ('$name', '$id', '$q', '$desc', NULL, NULL, NULL, NULL, NULL)";
$query = $conn->query($sql);
//$sql="UPDATE questions SET arg2 = NULL WHERE arg2 = ''";
//$query = $conn->query($sql);
//$sql="UPDATE questions SET test2 = NULL WHERE test2 = ''";
//$query = $conn->query($sql);
//}
//else{
  //$sql="INSERT INTO `tpp26`.`questions` (`id`, `question`, `description`, `difficulty`, `category`, `arg1`, `test1`, `arg2`, `test2`) VALUES (NULL, '$q', '$desc', '$dif', '$cat', '$arg1', '$test1', NULL, NULL)";
  //$query = $conn->query($sql);
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
//}

//$stuffJson = json_encode($items);
//echo $stuffJson;

//$ayy = json_decode($stuffJson, true);
//print_r($ayy);

$conn->close();

?>