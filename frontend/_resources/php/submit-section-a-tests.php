<?php
$location = "/data/personal/htdocs/rvictori/icompute/_resources/txt/section-a-tests.txt";
file_put_contents($location, $_POST['testsData']);

$location = "/data/personal/htdocs/rvictori/icompute/_resources/txt/section-a-test-content.txt";
file_put_contents($location, $_POST['testContentData']);

$location = "/data/personal/htdocs/rvictori/icompute/_resources/txt/section-a-test-teams.txt";
file_put_contents($location, $_POST['testTeamsData']);
?>
