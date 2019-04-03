<?php
$location = "/data/personal/htdocs/aswaenep/_resources/txt/section-a.txt";
$my_file = fopen($location, "w");
fwrite($my_file, $_POST['content']);
fclose($my_file);
?>
