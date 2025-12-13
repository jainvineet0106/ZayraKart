<?php
namespace App\Controllers;
use App\Models\CommonModel;

class Home extends BaseController
{
    public function index()
    {
        $commonmodel = new CommonModel();
        $data['categories'] = $commonmodel->getAllData('categories', ['status'=>1], [], '', true);
        $data['PBC'] = [];
        foreach($data['categories'] as $cat){
            $product = $commonmodel->getAllData('products', ['categories_id'=>$cat['id']], [], '1', true);
            if ($product) {
                $data['PBC'][] = $product;
            }
        }

        if (session()->has('userid')) {
            $userid = session()->get('userid');
            $data['user'] = $commonmodel->getAllData('user_accounts', ['id'=>$userid]);
            $data['cart'] = $commonmodel->getAllData('cart', ['userid'=>$userid]);
            $data['total_cart'] = count($data['cart']);
        }

        return view('frontend/index', $data);
    }
    
    public function shop($id)
    {
        $commonmodel = new CommonModel();
        $id = decode_id($id);
        $data['categories'] = $commonmodel->getAllData('categories', ['status'=>1]);
        if($id !=0 ){
            $data['products'] = $commonmodel->getAllData('products', ['categories_id'=>$id]);
        }else{
            $data['products'] = $commonmodel->getAllData('products');
        }
        if (session()->has('userid')) {
            $userid = session()->get('userid');
            $data['user'] = $commonmodel->getAllData('user_accounts', ['id'=>$userid]);
            $data['cart'] = $commonmodel->getAllData('cart', ['userid'=>$userid]);
            $data['total_cart'] = count($data['cart']);
        }
        return view('frontend/shop', $data);
    }

    public function contact()
    {
        $commonmodel = new CommonModel();
        $data['accounts'] = $commonmodel->getAllData('admin');
        if (session()->has('userid')) {
            $userid = session()->get('userid');
            $data['user'] = $commonmodel->getAllData('user_accounts', ['id'=>$userid]);
            $data['cart'] = $commonmodel->getAllData('cart', ['userid'=>$userid]);
            $data['total_cart'] = count($data['cart']);
        }

        return view('frontend/contact', $data);
    }

    public function message()
    {
        $commonmodel = new CommonModel();
        
        if($this->request->getMethod() == "POST"){
            $name = $this->request->getPost('name');
            $name = ucwords($name);
            $email = $this->request->getPost('email');
            $message = $this->request->getPost('message');

            $data = [
                'name'=>$name,
                'email'=>$email,
                'message'=>$message,
                'receive_date'=>date('d M, Y')
            ];
            $commonmodel->insertData('messages', $data);
            return redirect()->to('contact')->with('success', "Message Sent!");
        }
    }

    public function addtocart(){
        $commonmodel = new CommonModel();
        if($this->request->getMethod()=='POST'){
            $productid = $this->request->getPost('productid');
            $userid = $this->request->getPost('userid');
            $data = [
                'productid'=>$productid,
                'userid'=>$userid,
                'quantity'=>1
            ];
            $commonmodel->insertData('cart', $data);
            return 'success';
        }
    }
    
    public function updatecart(){
        $commonmodel = new CommonModel();
        if($this->request->getMethod()=='POST'){
            $id = $this->request->getPost('id');
            $quantity = $this->request->getPost('quantity');
            $data = [
                'quantity'=>$quantity
            ];
            $commonmodel->updateData('cart', $data, ['id'=>$id]);
        }
    }

    public function Cart()
    {
        $commonmodel = new CommonModel();
        $userid = session()->get('userid');
        $data['cart'] = $commonmodel->getAllData('cart', ['userid'=>$userid]);
        $data['products'] = $commonmodel->getAllData('products');
        return view('frontend/Cart/index', $data);
    }
    public function subscribe()
    {
        $commonmodel = new CommonModel();
        if($this->request->getMethod() == "POST"){
            date_default_timezone_set("Asia/Kolkata");
            $email = $this->request->getPost('email');

            $data['checkemail'] = $commonmodel->getAllData('subscribers', ['email'=>$email]);
            if($data['checkemail'])
            {
                return "already subscribed";
            }

            $data = ['email'=>$email,'receive_date'=>date('d-M-Y, h:i A')];
            $commonmodel->insertData('subscribers', $data);
            return "true";
        }else{
            return "Something Went Wrong Try Again!";
        }
    }

    public function Profile()
    {
        $commonmodel = new CommonModel();
        $userid = session()->get('userid');
        $data['user'] = $commonmodel->getAllData('user_accounts', ['id'=>$userid], ['id'=>'desc']);
        $data['addresses'] = $commonmodel->getAllData('useraddress', ['userid'=>$userid], ['id'=>'desc']);
        $data['orders'] = $commonmodel->getAllData('buy', ['userid'=>$userid], ['id'=>'desc']);

        $data['buyproducts'] = $commonmodel->getAllData('buyproducts');
        $data['products'] = $commonmodel->getAllData('products');
        
        if($this->request->getMethod() == "POST"){
            $title = $this->request->getPost('title');
            $title = ucwords($title);
            $address = $this->request->getPost('address');
            $pincode = $this->request->getPost('pincode');
            $mobile = $this->request->getPost('mobile');

            $data = [
                'userid'=>$userid,
                'title'=>$title,
                'address'=>$address,
                'pincode'=>$pincode,
                'mobile'=>$mobile
            ];
            $commonmodel->insertData('useraddress', $data);
            return redirect()->to('Profile')->with('success', "Address Updated!")->with('openTab', 'addresses');
        }

        return view('frontend/Profile/index', $data);
    }
    public function editaddress()
    {
        $commonmodel = new CommonModel();
        
        if($this->request->getMethod() == "POST"){
            $id = $this->request->getPost('addressid');
            $title = $this->request->getPost('title');
            $title = ucwords($title);
            $address = $this->request->getPost('address');
            $pincode = $this->request->getPost('pincode');
            $mobile = $this->request->getPost('mobile');

            $data = [
                'title'=>$title,
                'address'=>$address,
                'pincode'=>$pincode,
                'mobile'=>$mobile
            ];
            $commonmodel->updateData('useraddress', $data, ['id'=>$id]);
            return redirect()->to('Profile')->with('success', "Address Updated!")->with('openTab', 'addresses');
        }
    }
    
    public function editprofile()
    {
        $commonmodel = new CommonModel();
        $userid = session()->get('userid');
        $data['user'] = $commonmodel->getAllData('user_accounts', ['id'=>$userid]);
        if($this->request->getMethod() == "POST"){
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('mobile');
            $password = $this->request->getPost('password');

            if(!$password){
                foreach($data['user'] as $use){
                    $password = $use['password'];
                }
            }

            $data = [
                'name'=> $name,
                'password'=>$password,
                'email'=>$email,
                'mobile'=>$mobile
            ];

            $commonmodel->updateData('user_accounts', $data, ['id'=>$userid]);
            return redirect()->to('Profile')->with('success', "Profile Updated!");

        }
        return view('frontend/Profile/editprofile', $data);
    }

    public function returnitem($id){
        $commonmodel = new CommonModel();
        $orderid = decode_id($id);
        $data['orders'] = $commonmodel->getAllData('buy', ['orderid' =>$orderid]);
        // $data['buyproducts'] = $commonmodel->getAllData('buyproducts');
        // $data['products'] = $commonmodel->getAllData('products');
        
        // $userid = session()->get('userid');
        // $data['user'] = $commonmodel->getAllData('user_accounts', ['id'=>$userid], ['id'=>'desc']);
        // $data['addresses'] = $commonmodel->getAllData('useraddress', ['userid'=>$userid], ['id'=>'desc']);

        if($this->request->getMethod() == "POST"){
            $orderid = $this->request->getPost('orderid');
            $reason = $this->request->getPost('reason');
            $UPIid = $this->request->getPost('UPIid');
            $amount = $this->request->getPost('amount');
            $customerid = $this->request->getPost('customerid');
            $name = $this->request->getPost('name');
            $mobile = $this->request->getPost('mobile');
            $address = $this->request->getPost('address');
            $items = $this->request->getPost('items');

            $itemsarray = explode(',', $items);

            foreach($itemsarray as $item){
                $commonmodel->updateData('buyproducts', ['status'=>'Returned-Requested'], ['orderid'=>$orderid, 'productid'=>$item]);
            }


            $items = implode("#@", $itemsarray);

            $data = [
                'orderid'=>$orderid,
                'buyproductid'=>$items,
                'upiid'=>$UPIid,
                'reason'=>$reason,
                'total'=>$amount,
                'address'=>$customerid,
                'requestdate'=>date('Y-M-d'),
                'status'=>'Returned-Requested',
                'refundstatus'=>'Pending'
            ];

            $commonmodel->insertData('returnrequests', $data);
            $commonmodel->updateData('buy', ['status'=>'Returned-Requested'], ['orderid'=>$orderid]);

            return redirect()->to('/Profile')->with('success',message: 'Return request submitted successfully.')->with('openTab', 'orders');
        }


        
        return view('frontend/Profile/returnitem', $data);
    }
    
    public function getAddress($id)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('useraddress', ['id'=>$id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Address not found']);
    }
    
    public function uploadimage()
    {
        $commonmodel = new CommonModel();
        $userid = session()->get('userid');
        if (isset($_FILES['croppedImage'])) {
            $dir = FCPATH . 'public/frontend/images/useraccounts/';
            $tempFile = $_FILES['croppedImage']['tmp_name'];
            $filename = $userid.date(',Y,d M').".jpg";
            $target = $dir . $filename;            
            $data['image'] = $commonmodel->getAllData('user_accounts',['id'=>$userid]);
            foreach($data['image'] as $user){
                $oldimage = $user['image'];
            }
            $file = FCPATH."public/frontend/images/useraccounts/".$oldimage;
            if (file_exists($file)) {
                unlink($file);
            }
            if (move_uploaded_file($tempFile, $target)) {
                $data['user'] = $commonmodel->updateData('user_accounts', ['image'=>$filename], ['id'=>$userid]);
                return "Image saved as";
            } else {
                return "Failed to save image.";
            }
        }
        else{
            return "No Image";
        }
    }

    public function buy($proid, $userid, $redirectfrom){
        $commonmodel = new CommonModel();
        $userid = decode_id($userid);
        $proid = decode_id($proid);

        if($redirectfrom == 'cart'){
            $data['qty'] = $commonmodel->getAllData('cart', ['userid'=>$userid, 'productid'=>$proid]);
        }
        $data['addresses'] = $commonmodel->getAllData('useraddress', ['userid'=>$userid]);
        $data['products'] = $commonmodel->getAllData('products', ['id'=>$proid]);
        $admins = $commonmodel->getAllData('admin');
        $pa = $admins[0]['upiid'];
        $pn = $admins[0]['name'];

        if($this->request->getMethod()=='POST'){
            if (session()->has('buydata')) {
                session()->remove('buydata');
            }
            if (session()->has('buyproducts')) {
                session()->remove('buyproducts');
            }
            $saved_address = $this->request->getPost('saved_address');
            $subtotal = $this->request->getPost('subtotal');
            $packaging = $this->request->getPost('packaging');
            $tax = $this->request->getPost('tax');
            $total = $this->request->getPost('total');
            $payment = $this->request->getPost('payment');
            $buyQtyin = $this->request->getPost('buyQtyin');

            if(!$saved_address){
                $title = $this->request->getPost('title');
                $title = ucwords($title);
                $address = $this->request->getPost('address');
                $mobile = $this->request->getPost('mobile');
                $pincode = $this->request->getPost('pincode');
                $data = [
                    'userid'=>$userid,
                    'title'=>$title,
                    'address'=>$address,
                    'mobile'=>$mobile,
                    'pincode'=>$pincode
                ];
                $commonmodel->insertData('useraddress', $data);
                $data['newaddress'] = $commonmodel->getAllData('useraddress', ['userid'=>$userid], ['id'=>'desc'], 1);
                foreach($data['newaddress'] as $newaddress){
                    $saved_address = $newaddress['id'];
                }
            }

            $data['orderid'] = $commonmodel->getAllData('buy', [], ['id'=>'desc'], 1);
            $ordid = "ORD0";
            foreach($data['orderid'] as $oid){
                $ordid = $oid['orderid'];
            }
            preg_match('/([a-zA-Z]+)([0-9]+)/', $ordid, $matches);
            $number = $matches[2];
            $ordid = "ORD".++$number;

            $buyproductsdata[] = [
                'orderid'=>$ordid,
                'productid'=>$proid,
                'quantity'=>$buyQtyin
            ];
            
            $buydata = [
                'orderid'=>$ordid,
                'userid'=>$userid,
                'buyproductid'=>$proid,
                'address'=>$saved_address,
                'subtotal'=>$subtotal,
                'packaging'=>$packaging,
                'tax'=>$tax,
                'total'=>$total,
                'paymentmode'=>$payment,
                'paystatus'=>'Pending',
                'orderat'=>date('Y-M-d'),
                'deliverdat'=>date('Y-M-d', strtotime('+7 days')),
                'status'=>'Pending'
            ];
            if($payment == 'cash'){
                $buydata['paymentmode'] = 'CASH';
                $commonmodel->insertBatchData('buyproducts', $buyproductsdata);
                $commonmodel->insertData('buy', $buydata);
            }else if($payment == 'card'){
                $buydata['paymentmode'] = 'CARD';
                $buydata['paystatus'] = 'Paid';
                session()->set('buydata', $buydata);
                session()->set('buyproducts', $buyproductsdata);
                return view('frontend/carddetail/index');
            }elseif ($payment === 'upi') {
                $buydata['paymentmode'] = 'UPI';
                $buydata['paystatus'] = 'Paid';
                session()->set('buydata', $buydata);
                session()->set('buyproducts', $buyproductsdata);
                $amount = $total;

                helper('url');
                $upi = "upi://pay?pa={$pa}&pn=" . rawurlencode($pn) . "&am={$amount}&cu=INR";
                $savePath = FCPATH . 'public/frontend/qr/';
                if (!is_dir($savePath)) {
                    mkdir($savePath, 0755, true);
                }
                $fileName = 'upi_qr.png';
                $fileFull = $savePath . $fileName;
                
                require_once APPPATH . 'ThirdParty/phpqrcode/qrlib.php';
                if (file_exists($fileFull)) {
                    \QRcode::png($upi, $fileFull, QR_ECLEVEL_Q, 6, 2);
                }
                $upidata = [
                    'qr_url' => base_url('public/frontend/qr/' . $fileName),
                    'upi' => $upi,
                    'amount' => $amount,
                    'pn' => $pn
                ];
                
                return view('frontend/upi/index', $upidata);
            }
            
            $username = session()->get('username');
            return redirect()->to('/Profile')->with('success','Thanks, '.$username.'! Your order is on its way.')->with('openTab', 'orders');
        }
        return view('frontend/buy', $data);
    }
    public function placeorder($userid){
        if (session()->has('buydata')) {
            session()->remove('buydata');
        }
        if (session()->has('buyproducts')) {
            session()->remove('buyproducts');
        }
        $commonmodel = new CommonModel();
        $userid = decode_id($userid);
        $data['cartpro'] = $commonmodel->getAllData('cart', ['userid'=>$userid]);
        $data['addresses'] = $commonmodel->getAllData('useraddress', ['userid'=>$userid]);
        $data['products'] = $commonmodel->getAllData('products');

        $data['subtotal'] = 0;

        $buyproductsdata = [];

        foreach ($data['cartpro'] as $value) {
            foreach($data['products'] as $pro){
                if($pro['id'] ==  $value['productid']){
                    $data['subtotal'] = $data['subtotal'] + $value['quantity']*$pro['amount'];
                    $buyproductsdata[] = [
                        'orderid'=>'ORD',
                        'productid'=>$value['productid'],
                        'quantity'=>$value['quantity']
                    ];
                }
            }
        }

        if($this->request->getMethod()=='POST'){
            $saved_address = $this->request->getPost('saved_address');
            $subtotal = $this->request->getPost('subtotal');
            $packaging = $this->request->getPost('packaging');
            $tax = $this->request->getPost('tax');
            $total = $this->request->getPost('total');
            $payment = $this->request->getPost('payment');
            // $buyQtyin = $this->request->getPost('buyQtyin');

            if(!$saved_address){
                $title = $this->request->getPost('title');
                $title = ucwords($title);
                $address = $this->request->getPost('address');
                $mobile = $this->request->getPost('mobile');
                $pincode = $this->request->getPost('pincode');
                $data = [
                    'userid'=>$userid,
                    'title'=>$title,
                    'address'=>$address,
                    'mobile'=>$mobile,
                    'pincode'=>$pincode
                ];
                $commonmodel->insertData('useraddress', $data);
                $data['newaddress'] = $commonmodel->getAllData('useraddress', ['userid'=>$userid], ['id'=>'desc'], 1);
                foreach($data['newaddress'] as $newaddress){
                    $saved_address = $newaddress['id'];
                }
            }
            $data['orderid'] = $commonmodel->getAllData('buy', [], ['id'=>'desc'], 1);

            $ordid = "ORD0";
            foreach($data['orderid'] as $oid){
                $ordid = $oid['orderid'];
            }
            preg_match('/([a-zA-Z]+)([0-9]+)/', $ordid, $matches);
            $number = $matches[2];
            $ordid = "ORD".++$number;

            foreach ($buyproductsdata as &$row) {
                $row['orderid'] = $ordid;
            }
            unset($row);

            $buyproids = array_column($buyproductsdata, 'productid');
            $buypid = implode("#@", $buyproids);

            $buydata = [
                'orderid'=>$ordid,
                'userid'=>$userid,
                'buyproductid'=>$buypid,
                'address'=>$saved_address,
                'subtotal'=>$subtotal,
                'packaging'=>$packaging,
                'tax'=>$tax,
                'total'=>$total,
                'paymentmode'=>$payment,
                'paystatus'=>'Pending',
                'orderat'=>date('Y-M-d'),
                'deliverdat'=>date('Y-M-d', strtotime('+7 days')),
                'status'=>'Pending'
            ];
            if($payment == 'cash'){
                $buydata['paymentmode'] = 'CASH';
                $commonmodel->insertBatchData('buyproducts', $buyproductsdata);
                $commonmodel->insertData('buy', $buydata);
            }else if($payment == 'card'){
                $buydata['paymentmode'] = 'CARD';
                $buydata['paystatus'] = 'Paid';
                session()->set('buydata', $buydata);
                session()->set('buyproducts', $buyproductsdata);
                return view('frontend/carddetail/index');
            }elseif ($payment == 'upi') {
                $buydata['paymentmode'] = 'UPI';
                $buydata['paystatus'] = 'Paid';
                $buydata['paymentmode'] = 'UPI';
                $buydata['paystatus'] = 'Paid';
                session()->set('buydata', $buydata);
                session()->set('buyproducts', $buyproductsdata);
                
                $amount = $total;
                $pa = '9109859319@ybl';
                $pn = 'Zayrakart';

                helper('url');
                $upi = "upi://pay?pa={$pa}&pn=" . rawurlencode($pn) . "&am={$amount}&cu=INR";
                $savePath = FCPATH . 'public/frontend/qr/';
                if (!is_dir($savePath)) {
                    mkdir($savePath, 0755, true);
                }
                $fileName = 'upi_qr.png';
                $fileFull = $savePath . $fileName;

                require_once APPPATH . 'ThirdParty/phpqrcode/qrlib.php';
                if (file_exists($fileFull)) {
                    \QRcode::png($upi, $fileFull, QR_ECLEVEL_Q, 6, 2);
                }
                $upidata = [
                    'qr_url' => base_url('public/frontend/qr/' . $fileName),
                    'upi' => $upi,
                    'amount' => $amount,
                    'pn' => $pn
                ];
                
                return view('frontend/upi/index', $upidata);
            }
            $username = session()->get('username');
            $commonmodel->deleteData('cart', ['userid'=>$userid]);
            return redirect()->to('/Profile')->with('success','Thanks, '.$username.'! Your order is on its way.')->with('openTab', 'orders');
        }
        return view('frontend/placeorder', $data);
    }

    public function saveCardDetails()
    {
        $commonmodel = new CommonModel();
        $session = session();

        // Card data user ne form me diya hai
        $cardData = [
            'card_number' => $this->request->getPost('card_number'),
            'cardName' => $this->request->getPost('cardName'),
            'cardMonth'      => $this->request->getPost('cardMonth'),
            'cardYear'      => $this->request->getPost('cardYear'),
            'cardCvv'         => $this->request->getPost('cardCvv'),
        ];

        $buydata = $session->get('buydata');
        $buyproductsdata = $session->get('buyproducts');

        if ($buydata) {
            $commonmodel->insertBatchData('buyproducts', $buyproductsdata);
            // $commonmodel->insertData('buyproducts', $buyproductsdata);
            $commonmodel->insertData('buy', $buydata);
        }

        $session->remove('buydata');
        $session->remove('buyproducts');
        $userid = session()->get('userid');
        $commonmodel->deleteData('cart', ['userid'=>$userid]);
        return redirect()->to(base_url('Profile'))->with('success', 'Payment successful, order placed!')->with('openTab', 'orders');
    }

    public function upi_submit(){
        $commonmodel = new CommonModel();
        $request = service('request');
        $upi_id = $request->getPost('upi_id');

        $session = session();
        $buydata = $session->get('buydata');
        $buyproductsdata = $session->get('buyproducts');

        if ($buydata) {
            // $commonmodel->insertData('buyproducts', $buyproductsdata);
            $commonmodel->insertBatchData('buyproducts', $buyproductsdata);
            $commonmodel->insertData('buy', $buydata);
        }

        $session->remove('buydata');
        $session->remove('buyproducts');
        $userid = session()->get('userid');
        $commonmodel->deleteData('cart', ['userid'=>$userid]);
        return view('frontend/upi/upi_success', ['upi_id' => $upi_id]);
    }

    public function changestate()
    {
        $commonmodel = new CommonModel();
        if($this->request->getMethod() === 'POST'){
            $ordid = $this->request->getPost('orderid');
            $newStatus = $this->request->getPost('newStatus');
            $commonmodel->updateData('buy', ['status'=>$newStatus], ['orderid'=>$ordid]);
            $commonmodel->updateData('buyproducts', ['status'=>$newStatus], ['orderid'=>$ordid]);
            return 'Updated';
        }
    }
 
    public function deleteData($id,$tb,$redirect){
        $commonmodel = new CommonModel();
        $commonmodel->deleteData($tb,['id'=>$id]);
        if($redirect != 'cart'){
            return redirect()->to('/'.$redirect)->with('success','Your Record Deleted Successfully')->with('openTab', 'addresses');
        }
    }

    public function getorders($id)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('buy', ['id'=>$id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Order not found']);
    }
    public function getcustomer($id)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('useraddress', ['id'=>$id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Customer not found']);
    }
    public function getproduct($id)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('products', ['id'=>$id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Customer not found']);
    }
    public function getbuyproducts($pid, $oid)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('buyproducts', ['orderid'=>$oid,'productid'=>$pid]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Customer not found']);
    }
}
