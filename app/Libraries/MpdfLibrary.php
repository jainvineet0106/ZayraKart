<?php
namespace App\Libraries;

require_once APPPATH.'Libraries/dompdf/autoload.inc.php'; // correct path

use Dompdf\Dompdf;
use Dompdf\Options;

class MpdfLibrary
{
    protected $dompdf;

    public function __construct()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Poppins');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultPaperSize', 'custom');
        $options->set('defaultFont', 'Poppins');

        $this->dompdf = new Dompdf($options);
        // $this->dompdf = new Dompdf();
    }

    public function loadHtml($html)
    {
        $this->dompdf->loadHtml($html);
    }

    public function setPaper($size = 'A4', $orientation = 'portrait')
    {
        $this->dompdf->setPaper($size, $orientation);
    }

    public function setCustomPaperMM($width_mm, $height_mm)
    {
        $width_pt = $width_mm * 2.8346;
        $height_pt = $height_mm * 2.8346;
        $this->dompdf->setPaper([0, 0, $width_pt, $height_pt]);
    }

    public function render()
    {
        $this->dompdf->render();
    }

    public function stream($filename = 'document.pdf', $download = false)
    {
        $this->dompdf->stream($filename, ["Attachment" => $download]);
    }
    public function save($filepath)
    {
        file_put_contents($filepath, $this->dompdf->output());
    }

    public function addFooter($text, $font_size = 9)
    {
        $canvas = $this->dompdf->getCanvas();
        $canvas->page_text(40, $canvas->get_height() - 30, $text, null, $font_size, array(0,0,0));
    }
}
