$PathExcelSrc="C:\Users\Obsti\Documents\test.xlsx"
$Sheet1="Feuil1"
$Sheet2="Feuil2"

$objExcel = New-Object -ComObject Excel.Application
$objExcelFileOpen = $objExcel.Workbooks.Open($PathExcelSrc)
$objExcelSheetOpen = $objExcelFileOpen.sheets.item($Sheet1)
$objExcelSheetOpen2 = $objExcelFileOpen.sheets.item($Sheet2)
$rows = $objExcelSheetOpen.UsedRange.Rows.Count
$rows2 = $objExcelSheetOpen2.UsedRange.Rows.Count

<# 
On va insérer dans excel en feuil2 une formule pour nous indiquer 
le nombre de référence distincte en vue de créer le tableau 
#>

$totlignplusun = $rows2 + 1
$objExcelSheetOpen2.Cells.Item($totlignplusun,1).FormulaLocal = "=SOMMEPROD(1/NB.SI(A1:A$rows2;A1:A$rows2))"
$objExcelFileOpen.Save() # On sauvegarde la valeur de la formule
$nbreref = $objExcelSheetOpen2.cells.Item($totlignplusun,1).Value() # On lis la valeur

Write-Host "Nombres lignes feuil1"
write-host $rows
Write-Host "Nombres lignes feuil2"
write-host $rows2
Write-Host "Nombre référence"
write-host $nbreref

$analyse = @()
$analyse =$null
$analyse = @()

<#
Remplissage tableau analyse
en lisant la feuil1 du fichier Excel
Ce tableau va être de la forme
Ana 1 Ph Ana 2 Mg Ana 3 Zn Ana 4 Cu .......
#>

for($i=1; $i -le $rows; $i++){
    $analyse += $objExcelSheetOpen.cells.Item($i, 1).text
    $analyse += $objExcelSheetOpen.cells.Item($i, 2).text
    $analyse += "Valeur"
}

# Affichage tableau analyse
$nbreanalyse = $analyse.Length
Write-Host "Nombre élément taleau analyse"
Write-Host $nbreanalyse
write-host "Affichage tableau analyse"
write-host "-------------------------"

for($i=0; $i -lt $nbreanalyse; $i++){
    write-host $analyse[$i]
}
write-host "Fin affichage tableau analyse"
write-host "-----------------------------"

<#
Lecture fichier Excel feuil2 pour prendre la colonne 1 qui contient les références variable 
Le tableau à 2 dimensions tabref (lignes,colonnes)
lignes=rows2 -> nbre de lignes de la feuil2
colonnes=nbreanalyse -> nbre éléments du tableau analyse
On va forcer les colonnes provenant du tableau analyse à '-'
On force l'indice à 0
On va avoir un tableau du genre 2070 - - - - - .......
                                2071 - - - - - .......
Variable j ligne tableau
Variable k pour balayer la feuil2 du fichier excel
Variable w colonne pour incice du tableau                                
#>

$j=0
$k=0
$z=0
$w=0

$nbretableau=$nbreanalyse+1
$tabref = $null
[string[,]]$tabref = [string[,]]::New($nbreref,$nbretableau)
$var=''

for($k=1; $k -le $rows2; $k++){
    # On force la position de la référence en indice 0
    $w=0
    # On va tester si la référence a déjà été lue dans le fichier feuil2
    if($var -ne $objExcelSheetOpen2.cells.Item($k, 1).text){
        $var = $objExcelSheetOpen2.cells.Item($k, 1).text
        $tabref[$j,$w] = $objExcelSheetOpen2.cells.Item($k, 1).text
        # On remplit le nombre de colonnes en fonction du nombre d'indices du tableau analyse et on y met des '-'
        for ($w=0; $w -lt $nbreanalyse; $w++){
            $z=$w+1
            $tabref[$j,$z] = '-'
        }
        $j++
    }
}

# Affichage tableau détail
write-host "Affichage tableau détail"
$nbredetail = $nbreref * $nbreanalyse
write-host "Nombre détail"
write-host $nbredetail

$i=0

for($i=0; $i -lt $nbreref; $i++){
    for ($j=0; $j -le $nbreanalyse; $j++){
     write-host $tabref[$i,$j]
    }
}

# Relecture fichier Excel feuil2 pour trouver l'indice de la ligne échantillon dans le tableau
for($k=1; $k -le $rows2; $k++){
    $lecturereference = $objExcelSheetOpen2.cells.Item($k, 1).text # Lis la premiére colonne
    $lectureanalyse = $objExcelSheetOpen2.cells.Item($k, 2).text # Lis la deuxiéme colonne est ainsi de suite
    $lectureparametre = $objExcelSheetOpen2.cells.Item($k, 3).text
    $lecturevaleur = $objExcelSheetOpen2.cells.Item($k, 4).text
    # Lecture du tableau détail
    # On cherche la ligne de la référence (échantillon)
    for($i=0; $i -lt $nbreref; $i++){
        if ($tabref[$i,0] -eq $lecturereference){
            # On cherche la position analyse si on l'a trouvé 
            for($j=0; $j -le $nbreanalyse; $j++){
                if ($analyse[$j] -eq $lectureanalyse){
                    $u=$j+1
                    if ($analyse[$u] -eq $lectureparametre){
                        $tabref[$i,$u] = $analyse[$j]
                        $v=$u+1
                        $tabref[$i,$v] = $analyse[$u]
                        $z=$v+1
                        $tabref[$i,$z] = $lecturevaleur
                    }
                 }
            }
        }
    }
}

# Affichage tableau détail final
write-host "Affichage tableau détail final"
write-host "------------------------------"
write-host "Nombre détail"
write-host $nbredetail

$i=0
# On affiche les valeurs du tableau tabref
for($i=0; $i -lt $nbreref; $i++){
    for ($j=0; $j -le $nbreanalyse; $j++){
     write-host $tabref[$i,$j]
    }
}

write-host "Fin affichage tableau détail final"

# Initialisation du fichier excel

$objExcel = new-object -comobject excel.application 
$objExcel.Visible = $True 
$FinalExcelLocation = "C:\Users\Obsti\Documents\Resultat.xlsx"

# Création du fichier excel

if (Test-Path $FinalExcelLocation)  
{  
    # On ouvre le fichier excel
    $finalWorkBook = $objExcel.WorkBooks.Open($FinalExcelLocation)  
    $finalWorkSheet = $finalWorkBook.Worksheets.Item(1)  

}
else {  
    # On crée le fichier excel
    $finalWorkBook = $objExcel.Workbooks.Add()  
    $finalWorkSheet = $finalWorkBook.Worksheets.Item(1)
}

$i=0
$t=$i+1
# On mets les valeurs dans le tableau excel
for($i=0; $i -lt $nbreref; $i++){
    $t=$i+1
    $a=1
    for ($j=0; $j -le $nbreanalyse; $j++){
        $finalWorkSheet.Cells.Item($t,$a) =$tabref[$i,$j]
        $a++ 
    }
}

$finalWorkBook.SaveAs($FinalExcelLocation) # On sauvegarde le fichier excel

$objExcelFileOpen.close()
$objExcel.Quit()