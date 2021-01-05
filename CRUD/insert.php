<?php
require_once 'pdo.php';
if ( isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass'])){
    $sql = "INSERT INTO users (name,email,password) VALUES (:name , :email , :password)";
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute(
            array(
                ':name' => $_POST['name'],
                ':email' =>$_POST['email'],
                ':password' =>$_POST['pass']
            )
            );
    }catch (Exception $e){
        echo "Internal error, please contact support";
        error_log("error.php , SQL error=".$e->getMessage());
        return;
    };

}

if (isset($_GET['name'])) {
    $sql = "DELETE FROM users WHERE name= :name";
    try{
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':name' => $_GET['name']
        ));
    }catch (Exception $e){
        echo "Internal error, please contact support";
        error_log("error.php , SQL error=".$e->getMessage());
        return;
    };

}
$users = $pdo->query("SELECT * FROM users");
?>
<!-- ---------------------MVC------------------------------------------------ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert data</title>
</head>
<body>
    <h1>List of users</h1>
    <table border="2px">
    
        <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)){ ?>
            <tr>
        <td><?php echo $row['name'];?></td>
        <td><?php echo $row['email'];?></td>
        <td><?php echo $row['password'];?></td>
        <td>
        <a href="../../Building Web app (Coursera)/CRUD/insert.php?name=<?php echo $row['name'];?>">delete</a>
        </td>
        </tr>
        <?php } ?>
    
    
    </table>
    <h1>Add a new user</h1>
    <form action="" method="post">
        Name: <input type="text" name="name"><br>
        Email: <input type="email" name="email" ><br>
        Password: <input type="password" name="pass"> <br>
        <button type="submit">Sign Up</button>
    </form>
    <a href="delete.php">Delete user</a>
</body>
</html>