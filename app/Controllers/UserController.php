<?php
namespace App\Controllers;
use CodeIgnitor\Controllers;
use App\Models\UserModel;
use App\Models\CommonModel;

class UserController extends BaseController
{
    public function registration_here()
    {
        if($this->request->getMethod()=="POST"){

        	$UserModel = new UserModel();
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $mobile = $this->request->getPost('mobile');
            $password = $this->request->getPost('password');

            $data = $UserModel->where('email',$email)->first();
            if(!$data){
                $commonmodel = new CommonModel();
                $data = ['name'=>$name,'password'=>$password,'email'=>$email,'mobile'=>$mobile,'image'=>'dummy.png'];
                $commonmodel->insertData('user_accounts', $data);
                return "true";
            }else{
                return "Account already exists";
            }
        }else{
            return "Something Went Wrong!";
        }
    }
    public function login_here()
    {
        if($this->request->getMethod()=="POST"){

        	$UserModel = new UserModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $data = $UserModel->where('email',$email)->first();
            if($data){
                $pass = $data['password'];
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $verify_pass = password_verify($password, $hash);

                if($verify_pass){
                    $user_data = [
                        'userid'=>$data['id'],
                        'username'=>$data['name'],
                        'useremail'=>$data['email'],
                        'usermobile'=>$data['mobile'],
                        'userimage'=>$data['image'],
                        'userIsLoggedIn'=>TRUE
                    ];
                    $this->session->set($user_data);         
                    return 'true';
                }else{
                    return 'Password Wrong Try Again!!!';
                }
            }else{
                return 'User Not Found!';
            }
        }else{
            return 'Something Went Wrong!';
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
                    
        return redirect()->to('/');
    }

}
