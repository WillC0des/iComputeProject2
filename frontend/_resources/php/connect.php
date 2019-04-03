<?php

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
if(!empty($username)){
    if(!empty($password)){
        $host="localhost";
        $user="root";
        $pass="";
        $db="Users";
            $username=$_POST['username'];
        $password=$_POST['password'];
        $conn=mysqli_connect($host,$user,$pass,$db);
            $query="SELECT * from users where username='$username' and password='$password'";
            $result=mysqli_query($conn,$query);
            if(mysqli_num_rows($result)==1)
            {
                session_start();
                $_SESSION['Users']='true';
                header('location: index.php');
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