    $PathExcelSrc = "C:\Users\Obsti\Documents\test.xlsx"
    $Sheet = "Feuil1"

    $objExcel = New-Object -ComObject Excel.Application
    $objExcelFileOpen = $objExcel.Workbooks.Open($PathExcelSrc) # Ouverture du fichier Excel
    $objExcelSheetOpen = $objExcelFileOpen.sheets.item($Sheet)

    for($i=1; $i -le 4; $i++){ # On parcourt les 4 lignes du tableau

        Write-Host $objExcelSheetOpen.cells.Item($i, 1).text # On affiche les valeurs de la premiére colonne
        Write-Host $objExcelSheetOpen.cells.Item($i, 2).text
        Write-Host $objExcelSheetOpen.cells.Item($i, 3).text
        Write-Host $objExcelSheetOpen.cells.Item($i, 4).text

        if($objExcelSheetOpen.cells.Item($i, 3).text -eq ""){

            $objExcelSheetOpen.cells.Item(3, 3) = "X"

        }

    }

    # $objExcelSheetOpen.cells.Item(1, 5) = 'X' # Mets une croix dans la ligne 1 colonne 5

    $objExcelFileOpen.close() # On ferme le fichier Excel
    $objExcel.Quit()