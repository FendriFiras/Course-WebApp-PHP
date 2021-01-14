<?php
require_once "bootstrap.php";
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['logout'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}
$failure = false;
if (isset($_POST['year'])) {
    if (strlen($_POST['make']) < 1) {
        $failure = "Make is required";
    }
    if ((!is_numeric($_POST['year']) || (!is_numeric($_POST['mileage'])))) {
        $failure = "Mileage and year must be numeric";
    } 
    if($failure == false){
       
        $stmt = $pdo->prepare('INSERT INTO autos(make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(
            array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage']
            )
        );
    }
}

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $users = $pdo->query("SELECT * FROM autos");
?>

    <!DOCTYPE html>
    <html>

    <head>
    <title>Firas fendr8277f4b5</title>
    </head>

    <body>
        <div class="container">
            <h1>Tracking Autos for <?php echo $name ?></h1>
            <?php
            if ($failure !== false) {
                // Look closely at the use of single and double quotes
                echo ('<p style="color: red;">' . htmlentities($failure) . "</p>\n");
            } else {
                echo ('<p style="color: green;">Record inserted</p>');
            }
            ?>
            <fieldset>
            <form action="" method="POST">
                <label for="make">make:</label>
                <input type="text" name="make"><br>
                <label for="year">Year:</label>
                <input type="number" name="year"><br>
                <label for="mileage">Mileage:</label>
                <input type="number" name="mileage"><br>
                <button type="submit">Add</button>
                <button type="submit" name="logout">Logout</button>
            </form>
            </fieldset>
            
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
        </div>
    </body>
<?php
} else {
    die("Name parameter missing"); //if there is no name
}



?>