<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/StudentTest.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$student_id = 1; //To Do: Change This
$test = new StudentTest($dbConnect->getInstance());
if(isset($_POST["test_id"])){
    if(!$test->checkValidTest($student_id,$_POST["test_id"])){
        $result = $test->getTestQuestionIds($_POST["test_id"],$student_id);
        $marks_obtained = 0;
        $answer_query = "";
        while (($row=$result->fetch_assoc())){
            $question_id = $row["id"];
            $option_id = (isset($_POST[$question_id]))?$_POST[$question_id]:0;
            $answer_query = $answer_query . $test->createAnswerQuery($student_id,$question_id,$option_id);
            if($option_id == $row["answer"]){
                $marks_obtained = $marks_obtained + $row["marks"];
            }else{}
        }

        if($test->insertMarks($student_id,$_POST["test_id"],$marks_obtained) && $test->insertAnswers($answer_query)){
            $test->parentRedirect("Your answers are submitted successfully");
        }else{
            $test->deleteEntries($student_id,$_POST["test_id"]);
            $test->parentRedirect("Error processing the request");
        }
    }else{
        $test->parentRedirect("Error processing the request");
    }
}else{
    $test->parentRedirect("Error processing the request");
}