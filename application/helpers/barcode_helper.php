<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('barcode')){
//    function barcode($text){
//        require_once('tcpdf/tcpdf_barcodes_1d.php');
//        
//        $barcodeobj = new TCPDFBarcode($text, 'C128');
//
//        $barcodeobj->getBarcodePNG(2, 30, array(0,0,0));
//    }
    function barcode(){
        require_once('tcpdf/tcpdf_barcodes_1d.php');
    }
}