<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\CommonModel;
use App\Libraries\MpdfLibrary;

class Invoice extends BaseController
{
    public function amountwords($num)
    {
        $ones = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen',
            'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
        ];

        $tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        $levels = ['', 'Thousand', 'Lakh', 'Crore'];

        $num = round($num);
        $result = '';

        if ($num == 0) {
            return 'Zero';
        }

        $i = 0;
        while ($num > 0) {
            if ($i == 0) {
                $divider = 1000; // hundreds handled separately
                $chunk = $num % $divider;
                $num = floor($num / $divider);
            } elseif ($i == 1) {
                $divider = 100; // thousands handled separately
                $chunk = $num % $divider;
                $num = floor($num / $divider);
            } else {
                $divider = 100;
                $chunk = $num % $divider;
                $num = floor($num / $divider);
            }

            if ($chunk) {
                $hundreds = '';
                if ($chunk > 99) {
                    $hundreds = $ones[intval($chunk / 100)] . ' Hundred ';
                    $chunk = $chunk % 100;
                }

                if ($chunk > 19) {
                    $words = $tens[intval($chunk / 10)];
                    if ($chunk % 10) $words .= ' ' . $ones[$chunk % 10];
                } else {
                    $words = $ones[$chunk];
                }

                $result = trim($hundreds . $words . ' ' . ($levels[$i] ?? '')) . ' ' . $result;
            }
            $i++;
        }

        return trim($result) . ' Only';
    }

    public function index($id)
    {
        $pdf = new MpdfLibrary();
        $commonmodel = new CommonModel();
        $data['admins']  = $commonmodel->getAllData('admin', ['id'=>1]);
        $data['orders']  = $commonmodel->getAllData('buy', ['orderid'=>$id]);
        
        foreach($data['orders'] as $order){
            $address = $order['address'];
            $total = $order['total'];
            $paystatus = $order['paystatus'];
        }
        $data['customers']  = $commonmodel->getAllData('useraddress', ['id'=>$address]);
        $data['BYP']  = $commonmodel->getAllData('buyproducts', ['orderid'=>$id]);
        $data['products']  = $commonmodel->getAllData('products');

        $savePath = FCPATH . 'public/backend/images/orderqr/';
        if (!is_dir($savePath)) {
            mkdir($savePath, 0755, true);
        }
        $fileName = $id.'_qr.png';
        $fileFull = $savePath . $fileName;

        $qrtext = "OrderID: $id";
        
        $data['inwords'] = $this->amountwords($total);

        require_once APPPATH . 'ThirdParty/phpqrcode/qrlib.php';
        if (file_exists($savePath)) {
            \QRcode::png($qrtext, $fileFull, QR_ECLEVEL_Q, 6, 2);
        }

        $type = pathinfo($fileFull, PATHINFO_EXTENSION);
        $qrdata = file_get_contents($fileFull);
        $data['qrBase64'] = 'data:image/' . $type . ';base64,' . base64_encode($qrdata);

        $html = view('backend/pdf/invoice', $data);

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('invoice.pdf', false);

        if(is_file($fileFull)){
            unlink($fileFull);
        }

    }
}
