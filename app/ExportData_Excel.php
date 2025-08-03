<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportData_Excel extends Model
{
    public function exportExcel(string $filename, array $data, bool $is_srvstored=false,string $title='data_exported'){
        $index_row = 0;
        $index_col = 0;
        $spreadsheet = new Spreadsheet();
        $sheet= $spreadsheet->getActiveSheet();
        $sheet->setTitle($title);

        foreach($data as $row => $register){
            ++$index_row;
            if(is_array($register)){
                foreach($register as $col => $cell){
                    ++$index_col;
                    /* echo $index_row." ".$index_col."<br />"; */
                    if(isset($cell)&&!is_null($cell)){
                        $sheet->setCellValueByColumnAndRow($index_col, $index_row, $cell);
                    }
                }
            }else{
                $sheet->setCellValueByColumnAndRow($index_row, $index_col, $data[$index_row-1]);
            }          
            $index_col = 0;
        }
        $writer = new Xlsx($spreadsheet);
        if(!$is_srvstored){            
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            header("Cache-Control: max-age=0");
            header("Expires: Fri, 11 Nov 2011 11:11:11 GMT");
            header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");
            header("Cache-Control: cache, must-revalidate");
            header("Pragma: public");
            $writer->save("php://output");
        }else{
            $writer->save($filename.".xlsx");
        }
        /* [0] => | 'Vendor Name'| 'Order Date'| 'Total Product Price'|'Comission Price'|'Status'|'CartID'|'User Name'|'Payment Method' */

    }
}
