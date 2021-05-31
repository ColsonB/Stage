<?php
    try{
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
           
    $req = $BDD->prepare("SELECT analyse.analyse, analyse.parametre, analyse.resultat FROM analyse");
    $req->execute();
     
    $analyse = array(
            array("0.1"=>"Ana 1",
            "0.1.0" => "Ph",
            "0.1.0.0" => 7,
        ),
            array("1.1"=>"Ana 2",
            "1.1.O" => "Mg",
            "1.1.0.0" => 3,
            "1.1.1" => "K",
            "1.1.1.0" => 5,
        ),
    );

    foreach($analyse as $resultat){
      
    }

    var_dump($analyse);
?>