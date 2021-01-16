<?php
require_once "pdo.php";
session_start();

$msg = validatePos();
if(is_string($msg)){
    $_SESSION['error'] = $msg;
    header("Location: add.php");
    return;
}

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
    $stmt->execute(
        array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary']
        )
    );
    //insert position entries
    $profile_id=$pdo->lastInsertId();
    $rank =1;
    for($i=0;$i<9;$i++){
    if(! isset($_POST['year'.$i])) continue;
    if(! isset($_POST['desc'.$i])) continue;
    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];

    $stmt=$pdo->prepare('INSERT INTO position (profile_id,rank,year,description) VALUES (:p,:r,:y,:d)');
    $stmt->execute(array(
        ':p'=>$profile_id,
        ':r'=>$rank,
        ':y'=>$year,
        ':d'=>$desc
    ));
    $rank++;
}
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
        <p>
        Position: <input type="submit" id="addPos" value="+">
    <div id="position_fields">
    </div>
    </p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
    </form>

    <script type="text/javascript" src="jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        countPos = 0;
        
        $(document).ready(function() {
            window.console && console.log('Document ready called');
            $('#addPos').click(function(event) {
                event.preventDefault();
                if (countPos >= 9) {
                    alert("Maximum of nine position entries exceeded");
                    return;
                }
                countPos++;
                window.console && console.log("Adding position " + countPos);
                $('#position_fields').append(
                    '<div id="position' + countPos + '"> \
            <p>Year: <input type="text" name="year' + countPos + '" value="" /> \
            <input type="button" value="-" onclick="$(\'#position' + countPos + '\').remove();return false;"></p> \
            <textarea name="desc' + countPos + '" rows="8" cols="80"></textarea>\
            </div>');
            });
        });
    </script>
</fieldset>