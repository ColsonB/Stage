<?php
    try{
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tableau</title>
        <link rel='stylesheet' type='text/css' href='src/css/style.css'>
    </head>
    <body>
            <?php
                $analyse = array();

                $req = $BDD->prepare("SELECT echantillon.nom, analyse.nom, analyse.ph, analyse.calcium, analyse.Mg, analyse.Mn 
                FROM echantillon, analyse WHERE echantillon.id = analyse.idechantillon");
                $req->execute();

                $resultat = $req->fetchAll();
                $req->closeCursor();

                var_dump($resultat);
                echo json_encode($resultat);
            ?>
    </body>
</html>