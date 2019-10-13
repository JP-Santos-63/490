<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$host = "sql1.njit.edu";
$user = "tpp26";
$dbPassword = "hp8pCxxm";
$db = "tpp26";

//$data = json_decode(file_get_contents('php://input'), true);

//$ucid = $data['ucid'];
//$pass = $data['pass'];

//studentPass = Memes1337
//teacherPass = Password1

$ucid = $_POST["ucid"];
$pass = hash("sha512", $_POST["pass"]);

$conn = mysqli_connect($host, $user, $dbPassword, $db);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo 'Connected to the database.';

$result = mysqli_query($conn, "SELECT * FROM users WHERE ucid = '$ucid' and pass = '$pass'");

$rows = mysqli_num_rows($result);

if($rows==1){
    $stuff->Login = $ucid;
    $stuffJson = json_encode($stuff);
    echo $stuffJson;
}
else{
    $stuff->Login = "fail";
    $stuffJson = json_encode($stuff);
    echo $stuffJson;
}

//$hashed = hash('sha512', 'Password1');
//echo $hashed;

$conn->close();

?>
