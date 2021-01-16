<?php
require_once "pdo.php";
session_start();
?>
<html>

<head>
    <title>firas fendri </title>
</head>

<body>
<h1>Chuck Severance's Resume Registry</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green">' . $_SESSION['success'] . "</p>\n";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['user_id'])) {


        echo ('<table border="1">' . "\n");
        echo "<tr><th>Name</th>";
        echo "<th>Headline</th>";
        echo "<th>Action</th></tr>";
        $stmt = $pdo->query("SELECT * FROM profile ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo "<tr><td>";
            echo '<a href="view.php?profile_id=' . $row['profile_id'] . '">'.(htmlentities($row['first_name'].$row['last_name'])).'</a>';
            echo ("</td><td>");
            echo (htmlentities($row['headline']));
            echo ("</td><td>");
            echo ('<a href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> / ');
            echo ('<a href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>');
            echo ("</td></tr>\n");
        }
    ?>
        </table>
        <a href="add.php">Add New Entry</a><br><br>
        <a href="logout.php">Logout</a>
    <?php }
    else{
        echo ('<table border="1">' . "\n");
        echo "<tr><th>Name</th>";
        echo "<th>Headline</th>";
        $stmt = $pdo->query("SELECT * FROM profile ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>";
            echo '<a href="view.php?profile_id=' . $row['profile_id'] . '">'.(htmlentities($row['first_name'].$row['last_name'])).'</a>';
            echo ("</td><td>");
            echo (htmlentities($row['headline']));
            echo ("</td></tr>\n");
        }
        echo "<a href='login.php'>Please log in</a>";
    }

    ?>
    