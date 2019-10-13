<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$jsonData = json_decode(file_get_contents('php://input'), true);
$jsonString = json_encode($jsonData); // creating a php object

$jsonExam = $jsonData["exam_name"];

$jsonConst = array_values($jsonData["constraints"]); //May change later
$jsonVals = array_values($jsonData["test_cases"]);
$studCode = array_values($jsonData["code"]);

$expectedOut = array();
$argsToUse = array();
$constraints = array();

for ($i = 0; $i < sizeof($jsonConst); $i++) { // reads the constraints array, implodes them into an array to check
    $constToAdd = "";

    $const = $jsonConst[$i];
    $constToAdd = implode(" ", $const);

    array_push($constraints, $constToAdd);
}

for ($i = 0; $i < sizeof($jsonVals); $i++) { // double loop to check for args/outputs
    $casesToAdd = array();
    $argsToAdd = array();
    for ($j = 0; $j < sizeof($jsonVals[$i]); $j++) {
        //ARGS
        $args = $jsonVals[$i][$j]["args"];
        $args = explode(", ", $args);

        array_push($argsToAdd, $args);
        //OUTPUTS
        $outs = $jsonVals[$i][$j]["output"];

        array_push($casesToAdd, $outs);
    }
    array_push($expectedOut, $casesToAdd);
    array_push($argsToUse, $argsToAdd);
}

//$expectedOut = array(array(3, 2, 3), array(1, 2, 3), array(1, 2, 3)); //testcases, each array within the array of outs are testcases for a question
//students code output, each array hase mulitple outputs for mulitple testcases
//replaces above with the arrays given to me

$studentAns = $studCode; //empty array to populate with arrays
$scoresForTest = $jsonData["points"];
//$scoresForTest = array(25, 25, 50);

$grades = array(); //final grades
$questions = $jsonData["function_names"];
//$questions = array("def my_function():", "def addThis():", "def multThis():"); // functions to put from curl
$lengthQA = sizeof($questions); // # of questions given
//for ($i = 0; $i < $numPasses; $i++) {
//$listToAdd = array();
$studentAns = array();
//$textToExec = "def my_function():\n\tmyint=3\n\tprint(myint)\nmy_function()";
$stuff = $output;
$pointsOff = array();

$AddToFunc = '';
for ($i = 0; $i < sizeof($argsToUse); $i++) { //assorting into php arrays, to be visited
    $middle = $argsToUse[$i];

    for ($j = 0; $j < sizeof($middle); $j++) {
        $inner = $middle[$j];
        $AddToFunc = $AddToFunc . "(";

        for ($k = 0; $k < sizeof($inner); $k++) {
            $iWant = $inner[$k];

            //print_r($inner[sizeof($inner) - 1]);
            if ($inner[$k] == $inner[sizeof($inner) - 1]) {
                $AddToFunc = $AddToFunc . $iWant;
            } else {
                $AddToFunc = $AddToFunc . $iWant;
                $AddToFunc = $AddToFunc . ",";

            }
            //print_r($iWant);
            //$AddToFunc = $AddToFunc . $iWant;

        }
        $AddToFunc = $AddToFunc . ") ";

        //array_push($args, $AddToFunc);
    }
    //array_push($args, $argsAr);
} //end of args being put into arrays

$breakit = explode(" ", $AddToFunc); //print outs of args being arrayed

$args = array();
print_r("ARGS; ");
print_r($args);
//$argsAr = array(); // the args per test cases/question
$count = 0;

for ($i = 0; $i < sizeof($expectedOut); $i++) { //length of array of testcases
    $argsAr = array();

    for ($j = 0; $j < sizeof($expectedOut[$i]); $j++) { //length of questions testcases
        $pushThis = $breakit[$count];
        $count++;

        array_push($argsAr, $pushThis);
    }
    array_push($args, $argsAr);
}

//WHAT RUNS THE PROGRAM

$pointsOffFinal = array();
for ($i = 0; $i < $lengthQA; $i++) { //translates code, into php. Then checks the funcName, by length of questions
    $pointsOffReason = "";
    //$textToExec = "def my_function():\n\tmyint=3\n\treturn(myint)"; // students code

    $textToExec = $studCode[$i];
    $textToExec = str_replace("\\\\n\\\"\"", "\n", $textToExec);
    $textToExec = str_replace("\"\\\"", "", $textToExec);
    $textToExec = str_replace("\\\\", "\\", $textToExec);
    $textToExec = str_replace("\\n", "\n", $textToExec);
    $textToExec = str_replace("\\t", "\t", $textToExec);
    $textToExec = str_replace("\"", "", $textToExec);
    $textToExec = str_replace("+:", '"+":', $textToExec);
    $textToExec = str_replace("-:", '"-":', $textToExec);
    $textToExec = str_replace("*:", '"*":', $textToExec);
    $textToExec = str_replace("/:", '"/":', $textToExec);

    //print_r(substr($textToExec, 1, -1));
    //print_r(stripslashes($textToExec));
    $correctHeader = $questions[$i];

    $checkThis = explode(" ", $textToExec);

    $checkThis2 = explode("(", $checkThis[1]);

    $headerCheck = $checkThis2[0];
    //print_r($headerCheck);
    //echo "\n";

    //$correctHeader = "def " . $correctHeader . "()";
    //print_r($funcStuff[$useN + 1]);
    $useHeader = $correctHeader;
    $correctHeader = "def " . $correctHeader . "(nums)";
    if ($headerCheck != $useHeader) { //Header check

        $textToExec = str_replace($headerCheck, $useHeader, $textToExec);
        //print_r($correctHeader);
        //$headerCheck[0] = $correctHeader . ":";
        //$useHeader = $headerCheck[0];
        //$textToExec = implode("", $headerCheck);

        array_push($pointsOff, 2);
        $pointsOffReason = $pointsOffReason . "Incorrect Header\n";
    } else {array_push($pointsOff, 0);}
    //print_r("HEADER_CHECK\n");
    //print_r($headerCheck[0]);
    //CHECK CONSTRAINTS HERE
    $constCheck = explode(" ", $constraints[$i]);

    for ($l = 0; $l < sizeof($constCheck); $l++) {
        if ($constCheck[$l] == "") {
            array_push($pointsOff, 0); // if empty, means no constraints
        } elseif (strstr($textToExec, $constCheck[$l]) == false) {
            array_push($pointsOff, 2);
            $pointsOffReason = $pointsOffReason . "Didn't use \"$constCheck[$l]\" correctly\n";
        } //Identifies constraints not used, creates reason why.
    }

    $listToAdd = array();

    if (strstr($textToExec, "print") == true) {
        $textToExec = str_replace("print", "return", $textToExec);
        //print_r($pointsOff);
        array_push($pointsOff, 0);
    } // offset the error check because running code, thinks that print is there when it really is not

    for ($k = 0; $k < sizeof($args[$i]); $k++) { //goes by the arguments

        $j = $k + 1;

        $funcCall = $questions[$i] . $args[$i][$k]; // adjust to call the function with args

        $addToEnd = "print($funcCall)";

        $textToExec = $textToExec . "\n";

        $textToExec = $textToExec . $addToEnd;
        // where it executes
        print_r("-----\n");
        print_r($textToExec);

        $fileToGrade = fopen("gradeThis.py", "w"); //creates / opens the file
        $codeToExec = $textToExec; //What im writing to the file
        fwrite($fileToGrade, $codeToExec); //the file being written
        fclose($fileToGrade);
        $command = escapeshellcmd('python gradeThis.py'); //finds the file we just created

        $output = shell_exec($command); //executes the file and assigns the return to $output
        //print_r($helo);
        print_r("xXOUTPUTXx: $output\n");
        //echo $output;
        $output = explode("\n", $output);
        print_r($output);
        print_r("\n");
        array_push($listToAdd, $output[$k]); //check what you're pushing to the students array if something goes wrong
    }
    array_push($studentAns, $listToAdd);
    array_push($pointsOffFinal, $pointsOffReason);
}
print_r($studentAns);

print_r($expectedOut);
for ($i = 0; $i < $lengthQA; $i++) {
    $testcases = $expectedOut[$i];
    echo "TESTCASES:\n";
    print_r(sizeof($testcases));
    echo "\n";
    $studentAnswers = $studentAns[$i];
    $gimme = 0;
    $scoresPerQuestion = $scoresForTest[$i]; // score per question
    for ($j = 0; $j < sizeof($testcases); $j++) { //grades the question, one by one. then appends it to the score
        $check1 = $testcases[$j];
        $check2 = $studentAnswers[$j];

        $check1 = explode(" ", $check1);

        $check2 = explode(" ", $check2);

        $diff = intval($check1[0]) - intval($check2[0]);
        if ($diff == 0) {
            $gimme++; //gimme is the var to give the students points
        }
    }
    echo "Final:\n";
    echo $gimme;
    $score = $scoresPerQuestion;
    echo "\n";
    echo $score;
    $scorePerTestcase = $score / sizeof($testcases); // 25/3
    echo "\n";
    echo $score;
    $totalQuestionScore = $scorePerTestcase * $gimme;
    echo "\n";
    echo $totalQuestionScore;
    $totalQuestionScore = $scorePerTestcase -
    array_push($grades, $totalQuestionScore);
}
print_r($studentAnswers);

for ($i = 0; $i < sizeof($grades); $i++) {
    $comp = explode("\n", $pointsOffFinal[$i]);
    $subThis = sizeof($comp);
    $subThis = 2 * $subThis - 2;
    $grades[$i] = $grades[$i] - $subThis;
}
print_r($grades);
$totalScore = 0;
for ($i = 0; $i < sizeof($grades); $i++) { // adds up all the scores
    $totalScore = $totalScore + $grades[$i];

}
//for ($i = 0; $i < sizeof($pointsOff); $i++) { commented out because possible later use
//    $totalScore = $totalScore - $pointsOff[$i];
//
print_r("GRADES:\n");
print_r($grades);

print_r("Total Points: ");
print_r($totalScore);
print_r("\n Subtracted points: \n");
print_r($pointsOffFinal);
$url = $jsonData["url"]; // put in where its going
$ch = curl_init($url);
//$toSend = array('answers' => $totalScore, '');
//$toSend->exam_name = $jsonExam;
//$toSend->student = $jsonData["student"];
//$toSend->questions_ids = $jsonData["questions_ids"];
$toSend->instructor_comments = $pointsOffFinal;
$toSend->points_earned = $totalScore;
//$toSend->points_earned = $jsonData["points"];

//print_r($toSend);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($toSend));
//print_r(json_encode($toSend));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_exec($ch);
curl_close($ch);
