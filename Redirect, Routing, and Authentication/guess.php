<?php

session_start();
if (isset($_POST['game'])){
    $_SESSION['game']=$_POST['game'];
    if($_SESSION['game']<40){
        $_SESSION['msg']="Too low";
    }
    else if($_SESSION['game']>40){
        $_SESSION['msg']="Too much";
    }
    else{
        $_SESSION['msg']="you got it right";
    }
    header('Location: guess.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing game</title>
</head>
<body>
    <p>Guessing game...</p>

    <?php 
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'] ;
        echo $_SESSION['game'];
    }
    
    ?> 
    <form action="" method="post">
    <label for="">Input Guess</label>
    <input type="text" name="game"><br><br>
    <button type="submit">submit</button>
    </form>
    
</body>
</html>