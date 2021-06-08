<?php
    try{//Connexion à la base de données
        $BDD=new PDO('mysql:host=localhost; dbname=stage; charset=utf8','root','');
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }    
    
    //Requête pour récupérer l'analyse
    $req = "SELECT DISTINCT analyse FROM analyse ORDER BY analyse";
    $req_analyse = $BDD->query($req);
    $count_analyse = $req_analyse->rowCount();//Retourne le nombre de ligne

    $i=0;

    //Initialisation du tableau//

    while($analyse=$req_analyse->fetch(PDO::FETCH_ASSOC)){//Récupére les échantillons
    //FETCH_ASSOC retourne un tableau indexé par le nom de la colonne

        //Requête pour récupérer le paramétre de l'analyse
        $req_param = "SELECT DISTINCT parametre FROM analyse WHERE analyse='".$analyse['analyse']."'";
        $req_parametre = $BDD->query($req_param);

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
    $las_samp = "SELECT DISTINCT echantillon FROM analyse";
    $las_sample = $BDD->query($las_samp);
    $count_sample=$las_sample->rowCount();
 
	for($c=1;$c<$count_sample+1;$c++){	
		for($d=0;$d<$i;$d++){
			$tab[$c][$d]="x";
		}
	}

    $z=1;
    $j=0;

    //Remplissage du tableau//

    while($sample=$las_sample->fetch(PDO::FETCH_NUM)){

        //$tab[$z][$j]=$sample[0];
        //$j++;

        $query_distinct = "SELECT DISTINCT analyse FROM analyse WHERE echantillon='".$sample[0]."' ORDER BY analyse";
        $query_distinct_analyse = $BDD->query($query_distinct);

        while($distinct_method=$query_distinct_analyse->fetch(PDO::FETCH_NUM)){
                
            $query_param = "SELECT parametre, resultat FROM analyse WHERE analyse='".$distinct_method[0]."' AND echantillon='".$sample[0]."'";
            $query_parameter = $BDD->query($query_param);
                
            for($x=0; $x<$i; $x++){
            
                if($tab_titre[$x]==$distinct_method[0]){   
                    
                    $j=$x;

                    $tab[$z][$j]=$distinct_method[0];
                    $j++;

                    $tmp=$j;

                    while($parametre=$query_parameter->fetch(PDO::FETCH_NUM)){
                    
                        if($tab[0][$j]=="Parametre"){//Remplie le tableau avec les paramétres et les résultats

                            if($tab_titre[$j]==$parametre[0]){
                                
                                $tab[$z][$j]=$parametre[0];
                                $j++;

                                $tab[$z][$j]=$parametre[1];
                                $j++;

                            }
                            else{
                                $j=$j+2;
                            }
                        }
                            $j=$tmp;
                    }
                }    
            }
        }

        $j=0;
        $z++;
    }

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