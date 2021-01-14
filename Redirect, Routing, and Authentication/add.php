<?php
session_start();
require_once "bootstrap.php";
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $_SESSION['success'] = "Record inserted";
        header("Location: view.php");
        return;
    }
}

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
            if ($failure !== false) {
                // Look closely at the use of single and double quotes
                echo ('<p style="color: red;">' . htmlentities($failure) . "</p>\n");
            } 
            ?>
            <fieldset>
            <form action="" method="POST">
                <label for="make">make:</label>
                <input type="text" name="make"><br>
                <label for="year">Year:</label>
                <input type="text" name="year"><br>
                <label for="mileage">Mileage:</label>
                <input type="text" name="mileage"><br>
                <button type="submit">Add</button>
                <a href="logout.php">Logout</a>
            </form>
            </fieldset>
            
        </div>
    </body>
<?php
} else {
    die("Not logged in"); //if there is no name
}



?>