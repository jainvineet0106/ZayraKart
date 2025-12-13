<?php
namespace App\Controllers;
use CodeIgnitor\Controllers;
use App\Models\CommonModel;
use App\Models\StaffModel;
class Staff extends BaseController
{
    public function index()
    {
        if ($this->request->getMethod() == "POST") {

            $StaffModel = new StaffModel();
            $id = $this->request->getPost('id');
            $password = $this->request->getPost('password');

            $data = $StaffModel->where('staffid', $id)->first();
            if ($data) {
                $pass = $data['password'];
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $verify_pass = password_verify($password, $hash);

                if ($verify_pass) {
                    $adminsess_data = [
                        'id' => $data['id'],
                        'staffid' => $data['staffid'],
                        'name' => $data['name'],
                        'password' => $data['password'],
                        'email' => $data['email'],
                        'mobile' => $data['mobile'],
                        'staffIsLoggedIn' => TRUE
                    ];
                    $this->session->set($adminsess_data);
                    return redirect()->to('/staff/dashboard');
                } else {
                    $this->session->setFlashdata('error', 'Password Wrong Try Again!!!');
                    return redirect()->to('/staff');
                }
            } else {
                $this->session->setFlashdata('error', 'User Name Wrong Try Again!!!');
                return redirect()->to('/staff');
            }
        }
        return view('staff/login');
    }

    public function logout()
    {
        $this->session->destroy();
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/');
        }

        // 🔹 Clear browser cache headers
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Cache-Control', 'post-check=0, pre-check=0')
            ->setHeader('Pragma', 'no-cache');

        return redirect()->to('/staff');
    }


    public function dashboard()
    {

        $commonmodel = new CommonModel();
        $staffid = session()->get('staffid');
        $data['staffs'] = $commonmodel->getAllData('staff', ['staffid' => $staffid]);
        $today = date('Y-M-d');
        // $data['orders'] = $commonmodel->getAllData('buy', ['deliverdat' => "$today"]);
        $data['orders'] = $commonmodel->getAllData('buy', [
            'deliverdat' => "$today",
            'status !=' => 'Returned',
            'status !=' => 'Returned-Requested'
        ]);
        $data['returned'] = $commonmodel->getAllData('returnrequests', ['requestdate' => "$today"]);

        $data['orders'] = array_merge($data['orders'], $data['returned']);
        $data['total_orders'] = count($data['orders']);


        $data['Shipped'] = 0;
        $data['delivered'] = 0;
        $data['cancelled'] = 0;
        $data['returned'] = 0;

        foreach ($data['orders'] as $order) {

            if ($order['status'] == 'Shipped') {
                $data['Shipped']++;
            } else if ($order['status'] == 'Delivered') {
                $data['delivered']++;
            } else if ($order['status'] == 'Cancelled') {
                $data['cancelled']++;
            } else if ($order['status'] == 'Returned') {
                $data['returned']++;
            }
        }
        $data['addresses'] = $commonmodel->getAllData('useraddress');

        return view('staff/dashboard', $data);
    }


    public function changestate()
    {
        $commonmodel = new CommonModel();
        if ($this->request->getMethod() === 'POST') {
            $ordid = $this->request->getPost('orderid');
            $newStatus = $this->request->getPost('newStatus');
            if (trim($newStatus) == 'Delivered') {
                $commonmodel->updateData('buy', ['paystatus' => 'Paid'], ['orderid' => $ordid]);
                $commonmodel->updateData('buyproducts', ['status' => $newStatus], ['orderid' => $ordid]);
            }
            if (trim($newStatus) == 'Returned') {
                $commonmodel->updateData('buyproducts', ['status' => $newStatus], ['orderid' => $ordid, 'status'=>'Returned-Requested']);
                $commonmodel->updateData('returnrequests', ['status' => $newStatus], ['orderid' => $ordid]);
            }

            $commonmodel->updateData('buy', ['status' => $newStatus], ['orderid' => $ordid]);

            $data['orders'] = $commonmodel->getAllData('buy', [], ['id' => 'desc']);

            $totalOrders = count($data['orders']);
            $delivered = 0;
            $Shipped = 0;
            $cancelled = 0;
            $returned = 0;
            foreach ($data['orders'] as $o) {
                $s = ucfirst(strtolower($o['status']));
                if ($s === 'Delivered')
                    $delivered++;
                if ($s === 'Shipped')
                    $Shipped++;
                if ($s === 'Cancelled')
                    $cancelled++;
                if ($s === 'Returned')
                    $returned++;
            }
            $statusbar = [
                'Delivered' => $delivered,
                'Shipped' => $Shipped,
                'Cancelled' => $cancelled,
                'Returned' => $returned
            ];
            return json_encode($statusbar);
        }
    }

    public function getorders($id)
    {
        $commonmodel = new CommonModel();
        $result = $commonmodel->getAllData('buy', ['orderid' => $id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Order not found' . $id]);
    }
    public function getcustomer($id)
    {
        $commonmodel = new CommonModel();
        $result = $commonmodel->getAllData('useraddress', ['id' => $id]);
        if (!empty($result)) {
            return $this->response->setJSON($result[0]);
        }
        return $this->response->setJSON(body: ['error' => 'Customer not found']);
    }

}
