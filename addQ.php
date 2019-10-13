<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//Author:   Joao P. Santos

//$jsonData = json_decode(file_get_contents('php://input'), true);
//BREAKING QUESTION
$inData = file_get_contents('php://input');
/*$inData = explode("&", $inData);
$question = explode("=", $inData[0]); // the question being retrieved
//BREAKING DESCRIPTION
$desc = $inData[1];
$desc = explode("=", $inData[1]);
//BREAKING DIFFICULTY
$diff = explode("=", $inData[2]);
//print_r($diff[1]);
//BREAKING CATEGORY
$cat = explode("=", $inData[3]);
//$arg1 = ;
//$test1 = ;
//$arg2 = ;
//$test = ;
//echo $jsonData[1];
//$newUser = explode("&", $jsonData);
//echo substr($jsonData[1], 0, -9);

//QUESTION
$question = $question[1]; // the question being retrieved
$questionA = str_replace("%28", "(", $question); //step 1
$questionB = str_replace("%29", ")", $questionA); //step 2

//DESCRIPTION
$desc = str_replace("%20", " ", $desc[1]);

//DIFFICULTY
$diff = $diff[1];

//CATEGORY
$cat = $cat[1];

//$arg1 = ;
//$test1 = ;
//$arg2 = ;
//$test = ;
 */
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://web.njit.edu/~tpp26/addQ.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $inData,
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
    ),
));

$response = curl_exec($curl);
curl_close($curl);

echo $response;
