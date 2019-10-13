<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$jsonData = json_decode(file_get_contents('php://input'), true);
$jsonString = json_encode($jsonData); // creating a php object

//$jsonVals = array_values($jsonData["test_cases"]);
//$textToExec = $jsonData["code"][0]

$file = fopen("test.py", "w");
fwrite($file, "Hello");
fclose($file);
