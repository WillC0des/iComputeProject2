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

        if(mysqil_connect_error()) {
            die('Connect Error (' .mysqil_connect_errno() . ') ' 
            .  mysqil_connect_error());
        }
        else {
            $sql = "INSERT INTO account (username, password)
            values ('$username', '$password')";
            if($conn->query($sql)) {
                echo "New record is inserted succesfully";
            } 
            else {
                echo "Error: ". $sql . "<br>". $conn->error;
            }
            $conn->close();

        }
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