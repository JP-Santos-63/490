<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$jsonData = json_decode(file_get_contents('php://input'), true);

$url = $jsonData["url"]; // put in where its going
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_exec($ch);
curl_close($ch);
// same as sending curl, just used to fetch data
