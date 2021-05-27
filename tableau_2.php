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
        <title>Tableau 2</title>
        <link rel='stylesheet' type='text/css' href='src/css/style.css'>
    </head>
    <body>
            <?php
                $analyse = array();

                $req = $BDD->prepare("SELECT analyse.nom, analyse.ph, analyse.calcium, analyse.Mg, analyse.Mn 
                FROM analyse WHERE 1");
                $req->execute();

                $resultat = $req->fetch(PDO::FETCH_BOTH);
                $req->closeCursor();

                var_dump($resultat);
            ?>
    </body>
</html>