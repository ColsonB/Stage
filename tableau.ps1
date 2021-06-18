    $PathExcelSrc = "C:\Users\Obsti\Documents\test.xlsx"
    $Sheet = "Feuil1"

    $objExcel = New-Object -ComObject Excel.Application
    $objExcelFileOpen = $objExcel.Workbooks.Open($PathExcelSrc) # Ouverture du fichier Excel
    $objExcelSheetOpen = $objExcelFileOpen.sheets.item($Sheet)

    $objExcelSheetOpen.cells.item(1,3).text

    for($i=1; $i -le 4; $i++){ # On parcoure les 4 lignes du tableau

        Write-Host $objExcelSheetOpen.cells.Item($i, 1).text # On affiche les valeurs de la premiére colonne
        Write-Host $objExcelSheetOpen.cells.Item($i, 2).text
        Write-Host $objExcelSheetOpen.cells.Item($i, 3).text

    }

    $objExcelFileOpen.close() # On ferme le fichier Excel
    $objExcel.Quit()