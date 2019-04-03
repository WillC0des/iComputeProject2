<?php

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
if(!empty($username)){
    if(!empty($password)){
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "Teams";

        $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname)
    }
    else {
        echo "Password should not be empty.";
        die();
    }

}

else {
    echo "Username should not be empty.";
    die();
}
?>