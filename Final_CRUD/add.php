<?php
require_once "pdo.php";
session_start();

if (
    isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['mileage'])
) {

    // Data validation
    if (
        strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1
    ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }

    if (!is_numeric($_POST['year'])) {
        $_SESSION['error'] = 'Year must be an integer';
        header("Location: add.php");
        return;
    }
    if (!is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'mileage must be an integer';
        header("Location: add.php");
        return;
    }
    $sql = "INSERT INTO autos (make, model, year,mileage)
              VALUES (:make, :model, :year,:mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']
    ));
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
    <form action="" method="POST">
        <label for="make">make:</label>
        <input type="text" name="make"><br>
        <label for="model">Model:</label>
        <input type="text" name="model"><br>
        <label for="year">Year:</label>
        <input type="text" name="year"><br>
        <label for="mileage">Mileage:</label>
        <input type="text" name="mileage"><br>
        <button type="submit">Add</button>
        <a href="index.php">cancel</a>
    </form>
</fieldset>