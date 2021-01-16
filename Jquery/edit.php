<?php
require_once "pdo.php";
session_start();
$msg = validatePos();
if (is_string($msg)) {
    $_SESSION['error'] = $msg;
    header("Location: add.php");
    return;
}
if (
    isset($_POST['first_name']) && isset($_POST['last_name'])
    && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])
) {

    // Data validation
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?profile_id=" . $_POST['profile_id']);
        return;
    }
    if (!strpos($_POST['email'], '@')) {
        $_SESSION['error'] = "Email address must contain @";
        header("Location: login.php");
        return;
    }

    $sql = "UPDATE Profile SET first_name= :fn,last_name = :ln, email = :em , headline = :he,summary= :su
            WHERE profile_id = :p";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'],
        ':p' => $_POST['profile_id']
    ));
    //clear out the old position
    // Clear out the old position entries
    $stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
    $stmt->execute(array(':pid' => $_REQUEST['profile_id']));
    //insert 
    $rank = 1;
    for ($i = 0; $i < 9; $i++) {
        if (!isset($_POST['year' . $i])) continue;
        if (!isset($_POST['desc' . $i])) continue;
        $year = $_POST['year' . $i];
        $desc = $_POST['desc' . $i];

        $stmt = $pdo->prepare('INSERT INTO position (profile_id,rank,year,description) VALUES (:p,:r,:y,:d)');
        $stmt->execute(array(
            ':p' => $_POST['profile_id'],
            ':r' => $rank,
            ':y' => $year,
            ':d' => $desc
        ));
        $rank++;
    }
    $_SESSION['success'] = 'Record updated';
    header('Location: index.php');
    return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header('Location: index.php');
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
$profile_id = $row['profile_id'];
?>

<head>
    <title>firas fendri </title>
</head>

<p>Edit profile for <?= $_SESSION['name'] ?></p>
<fieldset>
    <form action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?= $n ?>"><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?= $e ?>"><br>
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?= $p ?>"><br>
        <label for="headline">Headline:</label><br>
        <input type="text" name="headline" value="<?= $k ?>"><br>
        <label for="summary">Summary:</label><br>
        <textarea name="summary" id="" cols="80" rows="10"><?= $s ?></textarea><br>
        <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</fieldset>