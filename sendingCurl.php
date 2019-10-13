<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//Author:   Joao P. Santos

//$jsonData = json_decode(file_get_contents('php://input'), true);

$jsonData = file_get_contents('php://input');
$jsonData = explode("=", $jsonData);
//echo $jsonData[1];
$newUser = explode("&", $jsonData);
//echo substr($jsonData[1], 0, -9);

$curl = curl_init();
$ucid = substr($jsonData[1], 0, -9); //"tpp26";
$pass = $jsonData[2]; //"Memes1337";

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://web.njit.edu/~tpp26/index.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "ucid=$ucid&pass=$pass&undefined=",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
    ),
));

$response = curl_exec($curl);

if (strlen($response) == 19) {
    //echo "win";
    $response = "1";
    //echo $response;
} else {
    //echo "fail";
    $response = "0";
    //echo $response;
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://aevitepr2.njit.edu/MyHousing/login.cfm",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "ucid=$ucid&pass=$pass&undefined=",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
    ),
));

$response1 = curl_exec($curl);
curl_close($curl);

$findThis = "48"; //48 is the number of hours it says on the page, when you fail to login
$found = strpos($response1, $findThis);

if ($found === false) {
    //echo "You're in";
    $response1 = "1";
    //echo $response1;
} else {
    //echo "NJIT doesn't like you";
    $response1 = "0";
    //echo $response1;
}
if ($response == "1" && $response1 == "0") {
    //echo "{'Login': '1' }";
    $stuff->Login = "1";
    $stuffJson = json_encode($stuff);
    echo $stuffJson;
} else if ($response == "0" && $response1 == "1") {
    //echo "{'Login': '2' }";
    $stuff->Login = "2";
    $stuffJson = json_encode($stuff);
    echo $stuffJson;
} else { $stuff->Login = "3";
    $stuffJson = json_encode($stuff);
    echo $stuffJson;}
