<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$sectionA = [];
$sql = "SELECT id, question, CorrectAnswer, Answer2, Answer3, Answer4 amount FROM Test";

if($result = mysqli_query($con,$sql))
{
  $i = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $sectionA[$i]['id']    = $row['id'];
    $sectionA[$i]['question'] = $row['question'];
    $sectionA[$i]['CorrectAnswer'] = $row['CorrectAnswer'];
	$sectionA[$i]['Answer2'] = $row['Answer2'];
	$sectionA[$i]['Answer3'] = $row['Answer3'];
	$sectionA[$i]['Answer4'] = $row['Answer4'];
    $i++;
  }

  echo json_encode($Test)
}
else
{
  http_response_code(404);
}