<?php
namespace App\Controllers;
use CodeIgnitor\Controllers;
use App\Models\CommonModel;
use App\Libraries\MpdfLibrary;
class Admin extends BaseController
{
    public function index(){
        return view('backend/login');
    }
    public function dashboard(){
        
    	$commonmodel = new CommonModel();
        $data['products'] = $commonmodel->getAllData('products');
        $data['total_products'] = count($data['products']);

        $data['subscribers'] = $commonmodel->getAllData('subscribers');
        $data['total_subscribers'] = count($data['subscribers']);

        $data['buy'] = $commonmodel->getAllData('buy');
        $data['total_buy'] = count($data['buy']);

        $data['admins'] = $commonmodel->getAllData('admin');
        $data['staffs'] = $commonmodel->getAllData('staff');
        $data['total_staff'] = count($data['staffs']);
        return view('backend/dashboard',$data);
    }
    public function messages(){
        $commonmodel = new CommonModel();
        $commonmodel->setTable('messages');
        $data['messages'] = $commonmodel->getpagination( [], ['id'=>'desc'], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/messages',$data);
    }
    public function subscribers(){
        $commonmodel = new CommonModel();$commonmodel->setTable('subscribers');
        $data['subscribers'] = $commonmodel->getpagination( [], ['id'=>'desc'], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/subscribers',$data);
    }
    public function useraccounts(){
        $commonmodel = new CommonModel();
        $data['useraddress'] = $commonmodel->getAllData('useraddress');
        $commonmodel->setTable('user_accounts');
        $data['user_accounts'] = $commonmodel->getpagination( [], ['id'=>'desc'], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/user_accounts',$data);
    }
    
    public function staff(){
        $commonmodel = new CommonModel();
        $commonmodel->setTable('staff');
        $data['staffs'] = $commonmodel->getpagination( [], ['id'=>'desc'], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/staff',$data);
    }
    
    public function staffdetails($id){
        $commonmodel = new CommonModel();
        $id = decode_id($id);
        $data['staffs'] = $commonmodel->getAllData('staff',['staffid'=>$id],['id'=>'desc']);
        $data['documents'] = $commonmodel->getAllData('staffdocuments');

        $commonmodel->setTable('staffattendance');
        $data['staffattendance'] = $commonmodel->getpagination( ['staffid'=>$id], ['id'=>'desc'], 12);
        $data['pager'] = $commonmodel->pager;
        return view('backend/staffes/staffdetails',$data);
    }
    public function staffadd(){
        $commonmodel = new CommonModel();
        $data['staffs'] = $commonmodel->getAllData('staff',[], ['id'=>'desc'], 1);
        if($this->request->getMethod() === 'POST'){

            foreach($data['staffs'] as $pro){
                $staffid = $pro['staffid'];
            }

            preg_match('/([a-zA-Z]+)([0-9]+)/', $staffid, $matches);
            $number = $matches[2];
            $staffid = "ST".++$number;

            $fullname = $this->request->getPost('fullname');
            $fullname = ucwords($fullname);
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('phone');
            $salary = $this->request->getPost('salary');
            $compressed_image = $this->request->getPost('compressed_image');
            $password = $this->request->getPost('password');

            if(
                trim($fullname) == ""||
                trim($email) == ""||
                trim($mobile) == ""||
                trim($salary) == "" ||
                trim($password) == ""
                ){
                return redirect()->to('admin/staffadd')->with('error', "Missing Field!");
            }

            $uploadedDocs = [];
            
            if ($files = $this->request->getFiles()) {
                if (isset($files['documents'])) {
                    foreach ($files['documents'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $newName = date('Ymd_His').'_'.uniqid().'.pdf';
                            $file->move(FCPATH . 'public/staff/images/documents', $newName);
                            $uploadedDocs[] = [
                                'staffid'=>$staffid,
                                'documents'=>$newName
                            ];
                        }
                    }
                }
            }
            if($uploadedDocs){
                $commonmodel->insertBatchData('staffdocuments', $uploadedDocs);
            }
            $data['documents'] = $commonmodel->getAllData('staffdocuments', ['staffid'=>$staffid]);
            $docuid = array_column($data['documents'], 'id');
            $docid = implode("#@", $docuid);
            
            if($compressed_image){
                $compressed_image = explode(',', $compressed_image)[1];
                $compressed_image = base64_decode($compressed_image);

                $imageName = date('Ymd_His') . '_' . uniqid() . '.jpg';
                $imgpath = FCPATH.'public/staff/images/'.$imageName;
                file_put_contents($imgpath, $compressed_image);
            }else{
                $imageName = 'dummy.png';
            }

            $data = [
                'staffid'=>$staffid,
                'name'=>$fullname,
                'password'=>$password,
                'email'=>$email,
                'mobile'=>$mobile,
                'image'=>$imageName,
                'joining'=>date('d-M-Y'),
                'documents'=>$docid,
                'salary'=>$salary
            ];
            $commonmodel->insertData('staff', $data);
            return redirect()->to('admin/staffdetails/'.encode_id($staffid))->with('success',"Staff Updated!");
        }
        return view('backend/staffes/staffadd',$data);
    }
    public function staffedit($id){
        $commonmodel = new CommonModel();
        $id = decode_id($id);
        $data['staffs'] = $commonmodel->getAllData('staff',['staffid'=>$id],['id'=>'desc']);
        $data['documents'] = $commonmodel->getAllData('staffdocuments', ['staffid'=>$id]);
        if($this->request->getMethod() === 'POST'){

            foreach($data['staffs'] as $pro){
                $oldimage = $pro['image'];
                $oldpassword = $pro['password'];
                $joining = $pro['joining'];
            }

            $fullname = $this->request->getPost('fullname');
            $fullname = ucwords($fullname);
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('phone');
            $salary = $this->request->getPost('salary');
            $compressed_image = $this->request->getPost('compressed_image');
            $password = $this->request->getPost('password');

            $uploadedDocs = [];
            
            if ($files = $this->request->getFiles()) {
                if (isset($files['documents'])) {
                    foreach ($files['documents'] as $file) {
                        if ($file->isValid() && !$file->hasMoved()) {
                            $newName = date('Ymd_His').'_'.uniqid().'.pdf';
                            $file->move(FCPATH . 'public/staff/images/documents', $newName);
                            $uploadedDocs[] = [
                                'staffid'=>$id,
                                'documents'=>$newName
                            ];
                        }
                    }
                }
            }
            if($uploadedDocs){
                $commonmodel->insertBatchData('staffdocuments', $uploadedDocs);
            }
            $data['documents'] = $commonmodel->getAllData('staffdocuments', ['staffid'=>$id]);
            $docuid = array_column($data['documents'], 'id');
            $docid = implode("#@", $docuid);
            
            if($compressed_image){
                $compressed_image = explode(',', $compressed_image)[1];
                $compressed_image = base64_decode($compressed_image);

                if($oldimage != 'dummy.png'){
                    $file = FCPATH."public\\staff\\images\\".$oldimage;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $imageName = date('Ymd_His') . '_' . uniqid() . '.jpg';
                $imgpath = FCPATH.'public/staff/images/'.$imageName;
                file_put_contents($imgpath, $compressed_image);
            }else{
                $imageName = $oldimage;
            }

            if(!$password){
                $password = $oldpassword;
            }

            $data = [
                'name'=>$fullname,
                'password'=>$password,
                'email'=>$email,
                'mobile'=>$mobile,
                'image'=>$imageName,
                'joining'=>$joining,
                'documents'=>$docid,
                'salary'=>$salary
            ];
            $commonmodel->updateData('staff', $data, ['staffid'=>$id]);
            return redirect()->to('admin/staffdetails/'.encode_id($id))->with('success', "Staff Updated!");
        }
        return view('backend/staffes/staffedit',$data);
    }
    public function staffcard($id){
        $pdf = new MpdfLibrary();
        $commonmodel = new CommonModel();
        $id = decode_id($id);
        $data['staffs'] = $commonmodel->getAllData('staff',['staffid'=>$id],['id'=>'desc']);
        $data['admins'] = $commonmodel->getAllData('admin');

        $savePath = FCPATH . 'public/staff/images/staffcard/';
        if (!is_dir($savePath)) {
            mkdir($savePath, 0755, true);
        }

        $html = view('backend/pdf/staffcard', $data);

        $pdf->loadHtml($html);
        $width = 90 * 2.8346;
        $height = 140 * 2.8346;
        $pdf->setPaper([0,0,$width,$height]);
        $pdf->render();
        $pdf->stream('staffcard.pdf', false);
    }
    public function product(){
        $commonmodel = new CommonModel();
        $data['categories'] = $commonmodel->getAllData('categories', [], ['id'=>'desc']);
        $commonmodel->setTable('products');
        $data['products'] = $commonmodel->getpagination( [], ['id'=>'desc'], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/product',$data);
    }
    public function addproduct(){
        $commonmodel = new CommonModel();
        $data['categories'] = $commonmodel->getAllData('categories', [], ['id'=>'desc']);
        if($this->request->getMethod() === 'POST'){

            $product_name = $this->request->getPost('product_name');
            $product_name = ucwords($product_name);
            $price = $this->request->getPost('price');
            $stock = $this->request->getPost('stock');
            $description = $this->request->getPost('description');
            $description = ucfirst($description);
            $description = str_replace("'","_",$description);
            $categories = $this->request->getPost('categories');

            $compressed_image = $this->request->getPost('compressed_image');
            $compressed_image = explode(',', $compressed_image)[1];
            $compressed_image = base64_decode($compressed_image);
            
            if($categories == "Other")
            {
                $categories = $this->request->getPost('new_category');
                $imageName = date('Ymd_His') . '_' . uniqid() . '.jpg';
                $imgpath = FCPATH.'public/frontend/images/category_img/'.$imageName;
                file_put_contents($imgpath, $compressed_image);
                $data = ['category'=>$categories, 'image'=>$imageName,'status'=>1];
                $commonmodel->insertData('categories',$data);
            }

            if(
                trim($product_name) == "" ||
                trim($price) == ""||
                trim($stock) == ""||
                trim($categories) == ""||
                trim($description) == ""
                ){
                return redirect()->to('admin/addproduct')->with('error', "Missing Field!");
            }
            $data['cat_id'] = $commonmodel->getAllData('categories', ['category'=>$categories], ['id'=>'desc']);

            foreach($data['cat_id'] as $id){
                $catid = $id['id'];
            }
            $imageName = $product_name. '.jpg';
            $imgpath = FCPATH.'public/frontend/images/Product/'.$imageName;
            file_put_contents($imgpath, $compressed_image);
            
            $data['pro_id'] = $commonmodel->getAllData('products', [], ['id'=>'desc'], 1);

            $proid = "PRO0";
            foreach($data['pro_id'] as $pid){
                $proid = $pid['product_id'];
            }
            preg_match('/([a-zA-Z]+)([0-9]+)/', $proid, $matches);
            $number = $matches[2];
            $proid = "PRO".++$number;

            $data = [
                'product_id'=>$proid,
                'name'=>$product_name,
                'description'=>$description,
                'amount'=>$price,
                'image'=>$imageName,
                'categories_id'=>$catid,
                'stock'=>$stock
            ];
            $commonmodel->insertData('products',$data);
            return redirect()->to('admin/product')->with('success', "$proid Products Added!");
        }
        
        return view('backend/addproduct', $data);
    }
    public function edit_product($id){
        $id = decode_id($id);
        $commonmodel = new CommonModel();
        $data['products'] = $commonmodel->getAllData('products',['id'=>$id]);
        $data['categories'] = $commonmodel->getAllData('categories', [], ['id'=>'desc']);
        if($this->request->getMethod() === 'POST'){
            
            foreach($data['products'] as $pro){
                $oldimage = $pro['image'];
                $proid = $pro['product_id'];
            }

            $product_name = $this->request->getPost('product_name');
            $product_name = ucwords($product_name);
            $price = $this->request->getPost('price');
            $stock = $this->request->getPost('stock');
            $description = $this->request->getPost('description');
            $description = ucfirst($description);
            $description = str_replace("'","_",$description);
            $categories = $this->request->getPost('categories');

            $compressed_image = $this->request->getPost('compressed_image');
            if($compressed_image){
                $compressed_image = explode(',', $compressed_image)[1];
                $compressed_image = base64_decode($compressed_image);

                $file = FCPATH."\\public\\frontend\\images\\Product\\".$oldimage;
                if (file_exists($file)) {
                    unlink($file);
                }
                $imageName = date('Ymd_His') . '_' . uniqid() . '.jpg';
                $imgpath = FCPATH.'public/frontend/images/Product/'.$imageName;
                file_put_contents($imgpath, $compressed_image);
            }else{
                $imageName = $oldimage;
            }

            $data['cat_id'] = $commonmodel->getAllData('categories', ['category'=>$categories], ['id'=>'desc']);

            foreach($data['cat_id'] as $cateid){
                $catid = $cateid['id'];
            }

            $data = [
                'name'=>$product_name,
                'product_id'=>$proid,
                'description'=>$description,
                'amount'=>$price,
                'image'=>$imageName,
                'categories_id'=>$catid,
                'stock'=>$stock
            ];
            $commonmodel->updateData('products',$data,['id'=>$id]);
            return redirect()->to('admin/product')->with('success', "$proid Product Updated!");
        }
        
        return view('backend/edit_product',$data);
    }

    public function deleteDocu($id,$tb,$staffid){
        $commonmodel = new CommonModel();

        if($tb == 'staffdocuments'){
            $data['documents'] = $commonmodel->getAllData($tb,['id'=>$id]);
            foreach($data['documents'] as $value){
                $documentsname = $value['documents'];
            }
            $file = FCPATH."public/staff/images/documents/".$documentsname;
            if (file_exists($file)){
                unlink($file);
            }
            $commonmodel->deleteData('staffdocuments',['id'=>$id]);
            $data['documents'] = $commonmodel->getAllData('staffdocuments', ['staffid'=>$staffid]);
            $docuid = array_column($data['documents'], 'id');
            $docid = implode("#@", $docuid);
            $commonmodel->updateData('staff', ['documents'=>$docid], ['staffid'=>$staffid]);
        }
        return 'success';        
    }
    public function deleteData($id,$tb,$redirect){
        $commonmodel = new CommonModel();

        if($tb == 'staff'){
            $data['image'] = $commonmodel->getAllData($tb,['id'=>$id]);
            foreach($data['image'] as $value){
                $imagename = $value['image'];
                $pdfname = $value['documents'];
                $staffid = $value['staffid'];
            }
            if($imagename != 'dummy.png'){
                $file = FCPATH."public/staff/images/".$imagename;
                if (file_exists($file)){
                    unlink($file);
                }
            }

            $document = explode("#@", $pdfname);

            foreach($document as $pdfid){
                $pdf = $commonmodel->getAllData('staffdocuments',['id'=>$pdfid]);
                foreach($pdf as $doc){
                    $file = FCPATH."public/staff/images/documents/".$doc['documents'];
                    if (file_exists($file)){
                        unlink($file);
                    }
                }
            }
            $commonmodel->deleteData('staffdocuments',['staffid'=>$staffid]);
        }

        if($tb == 'user_accounts'){
            $data['image'] = $commonmodel->getAllData($tb,['id'=>$id]);
            foreach($data['image'] as $value){
                $imagename = $value['image'];
            }
            $file = FCPATH."public/frontend/images/useraccounts/".$imagename;
            if (file_exists($file)){
                unlink($file);
            }
            $commonmodel->deleteData('useraddress',['userid'=>$id]);
        }

        if($tb == 'products'){

            $data['image'] = $commonmodel->getAllData($tb,['id'=>$id]);
            foreach($data['image'] as $value){
                $imagename = $value['image'];
                $catid = $value['categories_id'];
            }
            $file = FCPATH."public/frontend/images/Product/".$imagename;
            if (file_exists($file)){
                unlink($file);
            }
        }
        $commonmodel->deleteData($tb,['id'=>$id]);
        if($tb == 'products'){
            $data['cat'] = $commonmodel->getAllData($tb,['categories_id'=>$catid]);
            if(empty($data['cat'])){
                $data = ['status'=>0];
                $commonmodel->updateData('categories',$data,['id'=>$catid]);
            }
        }
        return redirect()->to('admin/'.$redirect)->with('success','Your Record Deleted Successfully');        
    }

    public function order(){
        $commonmodel = new CommonModel();
        $data['user_accounts'] = $commonmodel->getAllData('user_accounts');
        $data['useraddress'] = $commonmodel->getAllData('useraddress');
        $data['buyproducts'] = $commonmodel->getAllData('buyproducts');
        $data['products'] = $commonmodel->getAllData('products');
        $commonmodel->setTable('buy');
        $data['orders'] = $commonmodel->getpagination( [], ['id'=>'desc'], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/order', $data);
    }
    public function returned_orders(){
        $commonmodel = new CommonModel();
        $data['user_accounts'] = $commonmodel->getAllData('user_accounts');
        $data['useraddresses'] = $commonmodel->getAllData('useraddress');
        $data['buyproducts'] = $commonmodel->getAllData('buyproducts');
        $data['products'] = $commonmodel->getAllData('products');
        $commonmodel->setTable('returnrequests');
        $data['returnedOrders'] = $commonmodel->getpagination( [], [], 10);
        $data['pager'] = $commonmodel->pager;
        return view('backend/returned_orders', $data);
    }
    public function markattendance()
    {
        $commonmodel = new CommonModel();
        if($this->request->getMethod() === 'POST'){
            $staffid = $this->request->getPost('staffid');
            $attendance = $this->request->getPost('attendance');
            date_default_timezone_set("Asia/Kolkata");
            $data = [
                'staffid'=>$staffid,
                'time'=>date('h:i A'),
                'date'=>date('d'),
                'month'=>date('F'),
                'year'=>date('Y'),
                'status'=>$attendance
            ];
            $commonmodel->insertData('staffattendance', $data);
            
            // $data['orders'] = $commonmodel->getAllData('buy', [], ['id'=>'desc']);

            // $totalOrders = count($data['orders']);
            // $delivered = 0; $pending = 0; $processing = 0; $cancelled = 0; $revenue = 0;
            // foreach($data['orders'] as $o){
            //     $s = ucfirst(strtolower($o['status']));
            //     if($s==='Delivered') $delivered++;
            //     if($s==='Pending') $pending++;
            //     if($s==='Processing') $processing++;
            //     if($s==='Cancelled') $cancelled++;
            //     $revenue += floatval($o['total']);
            // }
            // $statusbar = [
            //     'Delivered'=>$delivered,
            //     'Processing'=>$processing+$pending,
            //     'Cancelled'=>$cancelled
            // ];
            return "success";
        }
    }
    public function changestate()
    {
        $commonmodel = new CommonModel();
        if($this->request->getMethod() === 'POST'){
            $ordid = $this->request->getPost('orderid');
            $newStatus = $this->request->getPost('newStatus');
            if($newStatus == 'Shipped'){
                $commonmodel->updateData('buy', ['deliverdat'=>date("Y-M-d")], ['orderid'=>$ordid]);
            }
            $commonmodel->updateData('buy', ['status'=>$newStatus], ['orderid'=>$ordid]);
            $commonmodel->updateData('buyproducts', ['status'=>$newStatus], ['orderid'=>$ordid]);
            
            $data['orders'] = $commonmodel->getAllData('buy', [], ['id'=>'desc']);

            $totalOrders = count($data['orders']);
            $delivered = 0; $pending = 0; $processing = 0; $cancelled = 0; $revenue = 0;
            foreach($data['orders'] as $o){
                $s = ucfirst(strtolower($o['status']));
                if($s==='Delivered') $delivered++;
                if($s==='Pending') $pending++;
                if($s==='Processing') $processing++;
                if($s==='Cancelled') $cancelled++;
                $revenue += floatval($o['total']);
            }
            $statusbar = [
                'Delivered'=>$delivered,
                'Processing'=>$processing+$pending,
                'Cancelled'=>$cancelled
            ];
            return json_encode($statusbar);
        }
    }

    public function getstaff($id)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('staff', ['staffid'=>$id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Staff not found'.$id]);
    }
    public function getorders($id)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('buy', ['orderid'=>$id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Order not found'.$id]);
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
        return $this->response->setJSON(body: ['error' => 'Product not found']);
    }
    public function getbuyproducts($pid, $oid)
    {
        $commonmodel = new CommonModel();
        $result  = $commonmodel->getAllData('buyproducts', ['orderid'=>$oid,'productid'=>$pid]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Product not found']);
    }
    public function setting()
    {
        $commonmodel = new CommonModel();
        $data['view'] = $commonmodel->getAllData('admin');
        if($this->request->getMethod() === 'POST'){
            foreach($data['view'] as $user){
                $oldpassword = $user['password'];
            }

            $name = $this->request->getPost('name');
            $name = ucwords($name);
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('mobile');
            $upiid = $this->request->getPost('upiid');
            $location = $this->request->getPost('location');
            $open_hour = $this->request->getPost('open_hour');
            $open_minute = $this->request->getPost('open_minute');
            $open_ampm = $this->request->getPost('open_ampm');
            $close_hour = $this->request->getPost('close_hour');
            $close_minute = $this->request->getPost('close_minute');
            $close_ampm = $this->request->getPost('close_ampm');
            $week_from = $this->request->getPost('week_from');
            $week_to = $this->request->getPost('week_to');

            $open = $open_hour.",".$open_minute.",".$open_ampm;
            $close = $close_hour.",".$close_minute.",".$close_ampm;

            $password = $this->request->getPost('password');
            if(!$password){
                $password = $oldpassword;
            }

            $data = [
                'name'=>$name,
                'username'=>$username,
                'email'=>$email,
                'password'=>$password,
                'mobile'=>$mobile,
                'address'=>$location,
                'upiid'=>$upiid,
                'open'=>$open,
                'close'=>$close,
                'week_from'=>$week_from,
                'week_to'=>$week_to
            ];
            $data['view'] = $commonmodel->updateData('admin',$data,['id'=>1]);

            return redirect()->to('admin/setting')->with('success', "Profile Updated!");  

        }
        return view('backend/setting',$data);
    }

}
