<# 
    $mdarray1 = @()
    $mdarray1_counter ++
    $mdarray1 += ,@($mdarray1_counter, 'Ana 1', 'Ph')
    $mdarray1_counter ++
    $mdarray1 += ,@($mdarray1_counter, 'Ana 2', 'Mg')
    $mdarray1_counterr ++
    $mdarray1 += ,@($mdarray1_counter, 'Ana 2', 'Zn')
    $mdarray1_counter ++
    $mdarray1 += ,@($mdarray1_counter, 'Ana 3', 'Mn')
    
    foreach($array10 in $mdarray1){
        Write-host ($array10)
    } 
#>

    $PathExcelSrc = "C:\Users\Obsti\Documents\test.xlsx"
    $Sheet = "Feuil1"

    $objExcel = New-Object -ComObject Excel.Application
    $objExcelFileOpen = $objExcel.Workbooks.Open($PathExcelSrc)
    $objExcelSheetOpen = $objExcelFileOpen.sheets.item($Sheet)

    $objExcelSheetOpen.cells.item(1,3).text

    for($i=1; $i -le 4; $i++){

        Write-Host $objExcelSheetOpen.cells.Item($i, 1).text
        Write-Host $objExcelSheetOpen.cells.Item($i, 2).text

    }

    $objExcelFileOpen.close()
    $objExcel.Quit()