<?php
require_once "pdo.php";
session_start();
?>
<html>

<head>
    <title>firas fendri </title>
</head>

<body>
<h1>welcome to the Automobiles Database</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green">' . $_SESSION['success'] . "</p>\n";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['name'])) {


        echo ('<table border="1">' . "\n");
        $stmt = $pdo->query("SELECT * FROM autos");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo (htmlentities($row['make']));
            echo ("</td><td>");
            echo (htmlentities($row['model']));
            echo ("</td><td>");
            echo (htmlentities($row['year']));
            echo ("</td><td>");
            echo (htmlentities($row['mileage']));
            echo ("</td><td>");
            echo ('<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ');
            echo ('<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>');
            echo ("</td></tr>\n");
        }
    ?>
        </table>
        <a href="add.php">Add New Entry</a><br><br>
        <a href="logout.php">Logout</a>
    <?php }
    else{
        echo "<a href='login.php'>Please log in</a>";
    }
    ?>