<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Excel {

    private $excel;

    public function __construct() {
        require_once APPPATH . 'third_party/PHPExcel.php';
        $this->excel = new PHPExcel();
    }

    public function load($path) {
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $this->excel = $objReader->load($path);
    }

    public function save($path) {
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($path);
    }

    public function stream($filename, $data = null, $header = null, $title = null) {
//        _var_dump($data);
//        _var_dump($header);
//        _var_dump($title);
//        die();
        if ($data != null) {
            $col = 'A';
            $colast = $col;
            $jml_col = 1;
            if($header != null){
                $jml_col = count($header);
            }
            for($i=0;$i<$jml_col-1;$i++){
                $colast++;
            }
            
            $rowNumber = 1;
            if($title!=null){
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                if(is_array($title)){
                    foreach($title as $val){
                        $this->excel->getActiveSheet()->mergeCells($col.$rowNumber.':'.$colast.$rowNumber);
                        $obrt = new PHPExcel_RichText();
                        $ob = $obrt->createTextRun($val);
                        $ob->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getCell($col.$rowNumber)->setValue($obrt);
                        $this->excel->getActiveSheet()->getStyle($col.$rowNumber)->applyFromArray($style);
                        $rowNumber++;
                    }
                }else{
                    $this->excel->getActiveSheet()->mergeCells($col.$rowNumber.':'.$colast.$rowNumber);
                    $obrt = new PHPExcel_RichText();
                    $ob = $obrt->createTextRun($val);
                    $ob->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getCell($col.$rowNumber)->setValue($obrt);
                    $this->excel->getActiveSheet()->getStyle($col.$rowNumber)->applyFromArray($style);
                    $rowNumber++;
                }
                $rowNumber++;
            }
            if($header != null){
                $col='A';
                foreach ($header as $val) {
                    $objRichText = new PHPExcel_RichText();
                    $ob = $objRichText->createTextRun(str_replace("_", " ", $val));
                    $ob->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getCell($col.$rowNumber)->setValue($objRichText);
                    $this->excel->getActiveSheet()->getStyle($col.$rowNumber)->applyFromArray($style);
                    $col++;
                }
            }
            $rowNumber++;
            foreach ($data as $row) {
                $col = 'A';
                foreach ($row as $cell) {
                    $this->excel->getActiveSheet()->setCellValue($col.$rowNumber, $cell);
                    $col++;
                }
                $rowNumber++;
            }
        }
//        header('Content-type: application/ms-excel');
//        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
//        header("Cache-control: private");
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        $objWriter->save($filename);
//        header("location: " . base_url() . "export/$filename");
//        unlink(base_url() . "export/$filename");
    }

    public function __call($name, $arguments) {
        if (method_exists($this->excel, $name)) {
            return call_user_func_array(array($this->excel, $name), $arguments);
        }
        return null;
    }
}