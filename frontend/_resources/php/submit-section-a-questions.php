<?php
$location = "/data/personal/htdocs/aswaenep/icompute/_resources/txt/section-a-questions.txt";

// Test if the file is ready for edits.
// if (is_writable($location)) {
//   echo "<script>It is writable.</script>";
// } else {
//   echo "<script>It is false.</script>";
// }

file_put_contents($location, $_POST['data']);
?>
