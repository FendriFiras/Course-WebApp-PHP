<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function validatePos(){
    for($i=0;$i<9;$i++){
        if(! isset($_POST['year'.$i])) continue;
        if(! isset($_POST['desc'.$i])) continue;
        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        if (strlen($year)==0 || strlen($desc)==0){
            return "all fields are required";
        }
        if (! is_numeric($year) ){
            return "Position year must be numeric";
        }
    }
    return true;
}

?>
