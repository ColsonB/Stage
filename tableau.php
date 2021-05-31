<?php
    try{
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
           
    $req = $BDD->prepare("SELECT analyse.analyse FROM analyse");
    $req->execute();
    $analyse = $req->fetchAll(PDO::FETCH_ASSOC);

    $req1 = $BDD->prepare("SELECT analyse.parametre FROM analyse");
    $req1->execute();
    $parametre = $req1->fetchAll(PDO::FETCH_ASSOC);

    $req2 = $BDD->prepare("SELECT analyse.resultat FROM analyse");
    $req2->execute();
    $resultat = $req2->fetchAll(PDO::FETCH_ASSOC);
     
    for($i=0; $i<count($analyse); $i++){
        for($z=0; $z<count($parametre); $z++){
            for($y=0; $y<count($resultat); $y++){

            }
        }
    }

   var_dump($analyse, $parametre, $resultat);
?>