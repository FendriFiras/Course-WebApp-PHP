<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firas Fendri</title>
</head>
<body>
    <h1>Welcome tomy gussing game</h1>
    <?php if(isset($_GET['guess'])){
            if(empty($_GET['guess'])){
                echo "<p>Your guess is too short</p>";
            }else{
                if(!is_numeric($_GET['guess'])){
                    echo "<p>Your guess is not a number";
                }else{
                    $x=$_GET['guess'];
                    if($x<200){
                        echo "<p>Your guess is too low";
                    }
                    if($x>200){
                        echo "<p>Your guess is too high";
                    }
                    if($x==200){
                        echo "<p>Congratulations - You are right'";
                    }
                }
            }

            
    }else{
        echo "<p>Missing guess parameter</p";
    }

    ?>
    
</body>
</html>