<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'third_party/vendor/autoload.php';

class M_pdf {
    public $param;
    public $pdf;

    public function __construct($param = ['c', 'A4']){
        $this->param = $param;
        $this->pdf = new \Mpdf\Mpdf();
    }

    function pdf($html, $filename){
        $this->pdf->WriteHTML($html);
        $this->pdf->Output($filename, 'I');
    }
}