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
    </p>
    <a href="index.php">Done</a>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>

</html>