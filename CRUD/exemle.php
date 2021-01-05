<?php
class personne{

    public $name="";
    public $prename="";

    public function __construct($name,$prename)
    {
        $this->name=$name;
        $this->prename=$prename;
    }
    public function affiche(){
        echo "Your name is:   ".$this->name." <br>your prename is :   ".$this->prename;
    }
}

class student extends personne{
    public $cin;

    public function __construct($cin,$name,$prename){
        personne::__construct($name,$prename);
        $this->cin=$cin;
    }

    public function affiche2(){
        personne::affiche();
        echo "<br> your CIN is :".$this->cin;
    }
    
}
    $p1 = new personne("firas","fendri");
    $p1->affiche();
    echo $p1->name;
    echo "<hr>";
    $s1 = new student(213213,"firas","fendri");
    $s1->affiche2();

?>