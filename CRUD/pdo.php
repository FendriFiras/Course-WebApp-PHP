<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=kuljeet','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//exemple
/*
$users = $pdo->query("SELECT * FROM user");

while ($row = $users->fetch(PDO::FETCH_ASSOC)){

    echo "<hr>";
    echo $row['name'];

}
*/


?>