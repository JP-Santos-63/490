<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//Author:   Joao P. Santos

$curl = curl_init();
$inData = file_get_contents('php://input');
//print_r($inData);
//$inData = explode("=", $inData);

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://web.njit.edu/~tpp26/getExamNames.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
    ),
));

$response = curl_exec($curl);
echo $response;
