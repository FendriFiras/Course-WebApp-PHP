<?php
require_once "pdo.php";
session_start();

if (
    isset($_POST['first_name']) && isset($_POST['last_name'])
    && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])
) {

    // Data validation
    if (
        strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1
    ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    if (!strpos($_POST['email'], '@')) {
        $_SESSION['error'] = "Email address must contain @";
        header("Location: login.php");
        return;
    }

    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );
    $_SESSION['success'] = 'Record Added';
    header('Location: index.php');
    return;
}

// Flash pattern
if (isset($_SESSION['error'])) {
    echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
    unset($_SESSION['error']);
}
?>

<head>
    <title>firas fendri </title>
</head>
<fieldset>
    <h1>Adding Profile for UMSI</h1>
    <form action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name"><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name"><br>
        <label for="email">Email:</label>
        <input type="text" name="email"><br>
        <label for="headline">Headline:</label><br>
        <input type="text" name="headline"><br>
        <label for="summary">Summary:</label><br>
        <textarea name="summary" id="" cols="80" rows="10"></textarea><br>
         <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</fieldset>