<?php
    try{//Connexion à la base de données
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
    
    //Requête pour récupérer l'analyse
    $req_analyse = $BDD->prepare('SELECT DISTINCT analyse FROM analyse WHERE echantillon ORDER BY analyse');
    $req_analyse->execute();
    $count_analyse = $req_analyse->rowCount();//Retourne le nombre de ligne

    $i=0;

    while($analyse=$req_analyse->fetch(PDO::FETCH_ASSOC)){
    //FETCH_ASSOC retourne un tableau indexé par le nom de la colonne

        //Requête pour récupérer le paramétre de l'analyse
        $req_parametre = $BDD->prepare("SELECT DISTINCT parametre FROM analyse WHERE analyse='nom'");
        $req_parametre->bindParam('nom', $analyse['analyse']);
        $req_parametre->execute();

        $count_parameter = $req_parametre->rowCount();

        $tab_titre[$i]=$analyse['analyse'];//Mets l'analyse dans le tableau
        $tab[0][$i]="Analyse";
        $i++;

        while($parametre = $req_parametre->fetch(PDO::FETCH_NUM)){
        //FETCH_NUM retourne un tableau indexé par le numéro de la colonne

            
            $tab_titre[$i]=$parametre[0];
            $tab[0][$i]="Parametre";
            $i++;

            $tab_titre[$i]="resultat";
            $tab[0][$i]="Resultat";
            $i++;
  
            }
    }
    //Requête qui sert à récupérer l'échantillon
    $las_sample = $BDD->prepare("SELECT DISTINCT echantillon FROM analyse WHERE analyse.echantillon");
    $las_sample->execute();
    $count_sample=$las_sample->rowCount();
 
	for($c=1;$c<$count_sample+1;$c++){	
		for($d=0;$d<$i;$d++){
			$tab[$c][$d]="x";
		}
	}

    $z=1;
    $j=0;

    while($sample=$las_sample->fetch(PDO::FETCH_NUM)){

        $tab[$z][$j]=$sample[0];
        $j++;

        $query_distinct_analyse = $BDD->prepare("SELECT DISTINCT analyse FROM analyse WHERE echantillon='tab' ORDER BY analyse");
        $query_distinct_analyse->bindParam('tab', $sample[0]);
        $query_distinct_analyse->execute();

        while($distinct_method=$query_distinct_analyse->fetch(PDO::FETCH_NUM)){
                
            $query_parameter = $BDD->prepare("SELECT parametre, resultat FROM analyse WHERE analyse='nom' AND echantillon='tab'");
            $query_parameter->bindParam('tab', $sample[0]);
            $query_parameter->bindParam('nom', $method[0]);
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
                    
                        while($tab[0][$j]=="Parametre"){//Remplie le tableau avec les paramétres et les résultats

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
    } 

    $j=0;
    $z++;

    $filename = 'file.csv';

    if(file_exists($filename)){
        unlink($filename);
    }

    $fp = fopen('file.csv', 'w');//Création d'un fichier excel

    $z=1;

    foreach($tab as $cle=>$ligne){//Parcour le tableau $lecture
        foreach($ligne as $key=>$valeur){
            if($key==0){
              $lecture = $tab[$cle][$key];
            }
            else{
              $lecture = $lecture.";".$valeur;
            }
        }
        $lecture = $lecture."\n";
        fwrite($fp, $lecture);//Ecrit dans le fichier excel
    }

    fclose($fp);//Ferme le fichier

    var_dump($tab);
?>