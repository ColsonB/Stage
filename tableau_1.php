<html>
    <?php        
           
    /* $req = "SELECT echantillon.nom, analyse.nom, analyse.ph, analyse.calcium, analyse.Mg, analyse.Mn 
            FROM echantillon, analyse WHERE echantillon.id = analyse.idechantillon";
     $result = mysql_query($query); */
     
    ?>
        <table>
    <?php

        $analyse = array(
            "tab1" => array('Ana 1', 'Ph' =>'7', 'Mg' =>'2', 'Mn' =>'4'),
            "tab2" => array('Ana 2', 'Ph' =>'0', 'Mg' =>'3.2', 'Mn' =>'1')
        );

        foreach ($analyse["tab1"] as $libelle => $i){
    ?>
            <tr>
                <td><?php echo $libelle; ?></td>
                <td><?php echo $i; ?></td>
            </tr>
    <?php
        }

        foreach ($analyse["tab2"] as $libelle => $i){
    ?>
            <tr>
                <td><?php echo $libelle; ?></td>
                <td><?php echo $i; ?></td>
            </tr>
    <?php
        }
    ?>  
        </table>
</html>


            