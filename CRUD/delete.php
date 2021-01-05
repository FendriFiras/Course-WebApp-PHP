<?php
require_once 'pdo.php';

if (isset($_POST['name'])) {
    $sql = "DELETE FROM users WHERE name= :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name']
    ));
}

?>
<!-- -------------------MVC-------------------------- -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete user</title>
</head>

<body>
    <h1>Delet a user by his name</h1>
    <form action="" method="post">
        select user name to delet : <input type="text" name="name">
        <button type="submit">Delete user</button>
    </form>
    <a href="insert.php">Insert user</a>
</body>

</html>