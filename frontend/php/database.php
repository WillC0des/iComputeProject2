<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Validate.
  if(trim($request->number) === '' || (float)$request->amount < 0)
  {
    return http_response_code(400);
  }

  // Sanitize.
  $number = mysqli_real_escape_string($con, trim($request->number));
  $amount = mysqli_real_escape_string($con, (int)$request->amount);


  // Create.
  $sql = "INSERT INTO `Test`(`id`,`question`,`CorrectAnswer`, `Answer2`, `Answer3`, `Answer4`) VALUES (null,'{$question}','{$CorrectAnswer}','{$Answer2}','{$Answer3}','{$Answer4}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $policy = [
      'question' => $question,
      'CorrectAnswer' => $CorrectAnswer,
	  'Answer2' => $Answer2,
	  'Answer3' => $Answer3,
	  'Answer4' => $Answer4,
      'id'    => mysqli_insert_id($con)
    ];
    echo json_encode($Test);
  }
  else
  {
    http_response_code(422);
  }
}