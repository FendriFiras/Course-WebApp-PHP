<?php
require_once "pdo.php";
session_start();

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}
// Flash pattern
if (isset($_SESSION['error'])) {
    echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
    unset($_SESSION['error']);
}

$n = htmlentities($row['first_name']);
$e = htmlentities($row['last_name']);
$p = htmlentities($row['email']);
$k = htmlentities($row['headline']);
$s = htmlentities($row['summary']);

?>
<head>
    <title>firas fendri</title>

</head>


<body>

    <h1>Profile information</h1>
    <p>First Name:
       <?= $n ?></p>
    <p>Last Name:
    <?= $e ?></p>
    <p>Email:
    <?= $p ?>
    </p>
    <p>Headline:<br />
    <?= $k ?>      </p>
    <p>Summary:<br />
    <?= $s ?>
    <p>
    <p>Position:<br />
    <ul>
        <?php  
        $stmt = $pdo->prepare("SELECT year,description FROM position where profile_id = :xyz");
        $stmt->execute(array(":xyz" => $_GET['profile_id']));
        $row2 = $stmt->fetchall();
        foreach($row2 as $r2){
            


        ?>
            
            <li><?= $r2['year'].':'.$r2['description']?></li>
         <?php   
            
        }
        ?>
    </ul>
    <p>
    </p>
    <p>Education:<br />
    <ul>
        <?php  
        $stmt = $pdo->prepare("SELECT year,institution_id FROM education where profile_id = :xyz");
        $stmt->execute(array(":xyz" => $_GET['profile_id']));
        $row3 = $stmt->fetchall();
        foreach($row3 as $r3){
            $stmt = $pdo->prepare("SELECT name FROM institution where institution_id = :xyz");
            $stmt->execute(array(":xyz" => $r3['institution_id']));
            $row4 = $stmt->fetchall();
            foreach($row4 as $r4){


        ?>
            
            <li><?= $r3['year'].':'.$r4['name']?></li>
         <?php   
            } 
        }
        ?>
    </ul>
    <p>
    </p>
    <a href="index.php">Done</a>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>

</html>