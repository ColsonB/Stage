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
        <table>
                <tr>
                    <td>Echantillon</td>
                    <td>&nbsp;</td>
                    <td>Ph</td>
                    <td>Calcium</td>
                    <td>Mg</td>
                    <td>Mn</td>
                </tr>
            <?php
                $req= "SELECT echantillon.nom, analyse.nom, analyse.ph, analyse.calcium, analyse.Mg, analyse.Mn 
                FROM echantillon, analyse WHERE echantillon.id = analyse.idechantillon";
                $RequestStatement=$BDD->query($req);
                
                for($i=1; $Tab=$RequestStatement->fetch(); $i++){
                    ?>
                        <tr>
                            <td><?php echo $Tab[0]; ?></td>
                            <td><?php echo $Tab[1]; ?></td>
                            <td><?php echo $Tab[2]; ?></td>
                            <td><?php echo $Tab[3]; ?></td>
                            <td><?php echo $Tab[4]; ?></td>
                            <td><?php echo $Tab[5]; ?></td>
                        </tr>
                    <?php
                }
            ?>
        </table>
    </body>
</html>