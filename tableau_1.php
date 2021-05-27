<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tableau 1</title>
        <link rel='stylesheet' type='text/css' href='src/css/style.css'>
    </head>
    <?php        
           
    /* $req = "SELECT echantillon.nom, analyse.nom, analyse.ph, analyse.calcium, analyse.Mg, analyse.Mn 
            FROM echantillon, analyse WHERE echantillon.id = analyse.idechantillon";
     $result = mysql_query($query); */
     
    ?>

    <?php

        $analyse = array(
            "tab1" => array('Ana 1', 'Ph' =>'7', 'Mg' =>'2', 'Mn' =>'4'),
            "tab2" => array('Ana 2', 'Ph' =>'0', 'Mg' =>'3.2', 'Mn' =>'1')
        );

        foreach ($analyse as $result){
            if(in_array('0', $result)){
                echo "***";
            }
        }

        var_dump($analyse);
    ?>
</html>


            