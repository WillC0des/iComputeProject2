<?php


if($_POST)
{
    $host= '35.237.181.128:3306';
    $user= 'root';
    $pass= 'iComputeProject';
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
        else{echo 'wrong username or password'}
}

?>

<h1>Login</h1>
<form method="POST">
username:<br>
    <input type="text" name="username"><br>
    password:<br><input type="password" name="password">
    <br>
    <input type="submit" value="Login">
</form>