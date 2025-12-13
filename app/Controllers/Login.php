<?php
namespace App\Controllers;
use CodeIgnitor\Controllers;
use App\Models\AdminModel;
class Login extends BaseController
{
    public function index()
    {
        if($this->request->getMethod()=="POST"){

            // $username = $this->request->getPost('name');
            // $password = $this->request->getPost('password');
            
        	$AdminModel = new AdminModel();
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $data = $AdminModel->where('username',$username)->first();
            if($data){
                $pass = $data['password'];
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $verify_pass = password_verify($password, $hash);

                if($verify_pass){
                    $adminsess_data = ['id'=>$data['id'],'name'=>$data['name'],'password'=>$data['password'],'IsLoggedIn'=>TRUE];
                    $this->session->set($adminsess_data);            
                    return redirect()->to('/admin/dashboard');
                }else{
                    $this->session->setFlashdata('error','Password Wrong Try Again!!!');
                    return redirect()->to('/admin');
                }
            }else{
                $this->session->setFlashdata('error','User Name Wrong Try Again!!!');
                return redirect()->to('/admin');
            }
        }else{
            return redirect()->to('/admin');
        }
    }

    public function logout(){
        $this->session->destroy();
        foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', time() - 3600, '/');
        }

        // 🔹 Clear browser cache headers
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                    ->setHeader('Cache-Control', 'post-check=0, pre-check=0')
                    ->setHeader('Pragma', 'no-cache');
                    
        return redirect()->to('/admin');
    }

}
