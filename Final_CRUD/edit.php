<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['make']) && isset($_POST['model'])
&& isset($_POST['year']) && isset($_POST['mileage']) ) {

    // Data validation
    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }

    if ( !is_numeric($_POST['year'])) {
        $_SESSION['error'] = 'Year must be an integer';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }
    if ( !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'mieage must be an integer';
        header("Location: edit.php?autos_id=".$_POST['autos_id']);
        return;
    }
    $sql = "UPDATE autos SET make= :make,
            model = :model, year = :year , mileage = :mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']
    ));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if (isset($_SESSION['error'])) {
    echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
    unset($_SESSION['error']);
}

$n = htmlentities($row['make']);
$e = htmlentities($row['model']);
$p = htmlentities($row['year']);
$k = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>
<head>
<title>firas fendri </title>
</head>

<p>Edit autos</p>
<fieldset>
    <form action="" method="POST">
        <label for="make">make:</label>
        <input type="text" name="make" value="<?= $n ?>"><br>
        <label for="model">Model:</label>
        <input type="text" name="model" value="<?= $e ?>"><br>
        <label for="year">Year:</label>
        <input type="text" name="year" value="<?= $p ?>"><br>
        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage" value="<?= $k ?>"><br>
        <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
        <button type="submit">Save</button>
        <a href="index.php">cancel</a>
    </form>
</fieldset>
