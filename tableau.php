<?php
    try{
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
           
    $req = sprintf("SELECT analyse.analyse, analyse.parametre, analyse.resultat FROM analyse");
    //$req->execute();

    echo sprintf($req);
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tableau</title>
        <link rel='stylesheet' type='text/css' href='src/css/style.css'>
    </head>
        <body>
            <div class="back">
                <div class="classement">
                    <table> 
                        <tr>
                            <th>Analyse</th>
                            <th>Paramétre</th>
                            <th>Résultat</th>  
                        </tr>
            
                        <?php
                        for($i=0; $tab=$req->fetch(); $i++){
                        ?>
                            <tr>
                                <td><?php echo $tab['analyse']; ?></td>
                                <td><?php echo $tab['parametre']; ?></td>
                                <td><?php echo $tab['resultat']; ?></td>
                            </tr>
                        <?php
                        }

                      ?>
                </div>
            </div>
        </body>
</html>