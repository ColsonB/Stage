<?php
    try{
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
           
    $req_analyse = $BDD->prepare("SELECT DISTINCT analyse FROM analyse ORDER BY analyse");
    $req_analyse->execute();
    $count_analyse = $req_analyse->rowCount();

        $i=0;
        
    while($tab_analyse=$req_analyse->fetch(PDO::FETCH_ASSOC)){

        $req_parametre = $BDD->prepare("SELECT DISTINCT analyse FROM analyse WHERE analyse = '%s'");
        $req_parametre->bindParam('%s', $tab_analyse['analyse']);
        $req_parametre->execute();
        $count_parameter = $req_parametre->rowCount();

        $tab_titre[$i]=$tab_analyse['analyse'];
        $tab[0][$i]="Analyse";

        while($parametre = $req_parametre->fetch(PDO::FETCH_NUM)){

            $tab_titre[$i]=$parametre[0];
            $tab[0][$i]="Parametre";
            $i++;

            $tab_titre[$i]="resultat";
            $tab[0][$i]="Resultat";
            $i++;

        }
    }

    $z=1;
    $j=0;

    $query_distinct_method = $BDD->prepare("SELECT DISTINCT analyse FROM analyse");
    $query_distinct_method->execute();

    while($distinct_method=$query_distinct_method->fetch(PDO::FETCH_NUM)){
        
        $query_parameter = $BDD->prepare("SELECT DISTINCT parametre, resultat FROM analyse");
        $query_parameter->execute();

        for($x=0; $x<$i; $x++){

            if($tab_titre[$x]==$distinct_method[0] && $tab_titre[$x+1]==$distinct_method[1]){
                $j=$x;
                $tab[$z][$j]=$distinct_method[0];
                $j++;

                $tab[$z][$j]=$distinct_method[1];
                $j++;

                $tmp=$j;

                while($parametre=$query_parameter->fetch(PDO::FETCH_NUM)){

                    while($tab[0][$j]=="Parametre"){

                        if($tab_titre[$j]==$parametre[0]){
                            
                            $tab[$i][$j]=$parametre[0];
                            $j++;

                            $tab[$i][$j]=$parametre[1];
                            $j++;

                            $tab[$i][$j]=$parametre[2];
                            $j++;

                            $tab[$i][$j]=$parametre[3];
                            $j++;
                        }
                        else{
                            $j=$j+4;
                        }
                    }
                    $j=$tmp;
                }
            }

        }
    }

    $j=0;
    $i++;

    foreach($tab as $index=>$ligne){
        foreach($ligne as $ind=>$valeur){
            if($ind == 0){
                $lecture=$tab[$index][$ind];
            }
            else{
                $lecture=$lecture.','.$valeur;
            }
        }
        $lecture=$lecture."\n";
        echo $lecture;
    }

    var_dump($tab); 

?>