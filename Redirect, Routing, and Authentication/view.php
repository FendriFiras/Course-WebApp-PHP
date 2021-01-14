<?php
require_once "bootstrap.php";
session_start();
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_SESSION['name'])) {
    $users = $pdo->query("SELECT * FROM autos");
?>

    <!DOCTYPE html>
    <html>

    <head>
    <title>Firas fendri7c011f8d</title>
    </head>

    <body>
        <div class="container">
            <h1>Tracking Autos for <?php echo $_SESSION['name'] ?></h1> 
            <?php
            if (isset($_SESSION['success'])) {
                echo ('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
                unset($_SESSION['success']);
            }
            ?>
            <h1>Automobiles</h1>
            <table border="2px">
            <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)) { ?>
                
            <tr>
                <th>Make</th>
                <th>year</th>
                <th>mileage</th>
            </tr>
                <tr>
                    <td><?php echo $row['make']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['mileage']; ?></td>

                </tr>
                
            <?php } ?>
            </table>
        <a href="add.php">Add New</a>
        | <a href="logout.php">Logout</a>
        </div>
    </body>
<?php
} else {
    die("Not logged in"); //if there is no name
}



?>