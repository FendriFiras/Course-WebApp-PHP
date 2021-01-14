<?php

session_start();
if( ! isset($_SESSION['pizza'])){
    echo "session is empty";
    $_SESSION['pizza']=0;
}elseif($_SESSION['pizza'] <3){
    $_SESSION['pizza']++;
    echo "ading one";
}else{
    session_destroy();
    session_start();
    echo "session restarted";
}
?>
<a href="session.php">refrech</a>
<p>our sessiuon id: <?php echo (session_id());?></p>
<pre>
    <?php echo print_r($_SESSION); ?>

</pre>