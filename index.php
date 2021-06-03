<?php
    try{ //Connexion à la base de données
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
    
    $i=0;

    //Requête pour récupérer l'analyse
    $req_analyse = $BDD->prepare('SELECT DISTINCT analyse FROM analyse');
    $req_analyse->execute();
    $count_analyse = $req_analyse->rowCount(); //Retourne le nombre de ligne

    while($analyse=$req_analyse->fetch(PDO::FETCH_ASSOC)){ //Permet de remplir le tableau analyse
    //FETCH_ASSOC retourne un tableau indexé par le nom de la colonne

        //Requête pour récupérer le paramétre de l'analyse
        $req_parametre = $BDD->prepare('SELECT parametre FROM analyse WHERE analyse=:nom');
        $req_parametre->bindParam(':nom', $analyse['analyse']);
        $req_parametre->execute();

        $count_parameter = $req_parametre->rowCount();


        $tab_titre[$i]=$analyse['analyse'];//On mets l'analyse dans le tableau
        $tab[0][$i]="Analyse";
        $i++;

        while($parametre = $req_parametre->fetch(PDO::FETCH_NUM)){ //Permet de remplir le tableau analyse
        //FETCH_NUM retourne un tableau indexé par le numéro de la colonne

            $tab_titre[$i]=$parametre[0];//On mets le paramétre dans le tableau
            $tab[0][$i]="Parametre";
            $i++;

            $tab_titre[$i]='resultat';
            $tab[0][$i]="Resultat";
            $i++;
  
            }
        }

    $z=1;
    $j=0;

    $query_distinct_analyse = $BDD->prepare("SELECT DISTINCT analyse FROM analyse ORDER BY analyse");
    $query_distinct_analyse->execute();

    while($distinct_method=$query_distinct_analyse->fetch(PDO::FETCH_NUM)){

        $query_parameter = $BDD->prepare('SELECT DISTINCT parametre, resultat FROM analyse WHERE analyse=:tab');
        $query_parameter->bindParam(':tab', $distinct_method[0]);
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
                            
                            $tab[$z][$j]=$parametre[0];
                            $j++;

                            $tab[$z][$j]=$parametre[1];
                            $j++;

                            $tab[$z][$j]=$parametre[2];
                            $j++;

                            $tab[$z][$j]=$parametre[3];
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
    $z++;

    $z=1;

    foreach($tab_titre as $cle=>$ligne){ //Permet de lire le tableau $tab_titre
        echo $ligne.',';
    }

    var_dump($tab_titre);
?>
