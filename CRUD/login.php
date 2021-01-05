<?php
require_once 'pdo.php';
if(isset($_POST['name']) && isset($_POST['pass'])){
    echo "handling POST data...";
    $e = $_POST['name'];
    $p = $_POST['pass'];

    $sql = "SELECT email FROM users WHERE name = :name AND password =:password";
    $stmt =$pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $e,
        ':password' => $p
    ));
    $row =  $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row == FALSE){
        echo "login incorrect";
    }else{
        echo "login correct";
    }
}
?>
<!-- 
-----------------------MVC------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    <h1>Log In</h1>
    <form action="" method="post">
    Name: <input type="text" name="name"><br>
    password: <input type="password" name="pass"><br>
    <button type="submit">Log in</button>
    </form>
</body>
</html>