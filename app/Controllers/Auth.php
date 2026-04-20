<?php
namespace App\Controllers;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function index()
    {
        
        if(session()->get('logged_in')) {
            return redirect()->to('/dashboard'); 
        }
        return view('login_view');
    }

    public function process()
    {
        $session = session();
        $model = new AdminModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $data = $model->where('username', $username)->first();
        
        if($data){
            $pass = $data['password'];
            // Verifikasi kecocokan password yang diinput dengan hash di database
            $verify_pass = password_verify($password, $pass);
            
            if($verify_pass){
                $ses_data = [
                    'id_pengguna' => $data['id_pengguna'],
                    'nama'        => $data['nama'],
                    'role'        => $data['role'],
                    'logged_in'   => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard'); // Login berhasil
            }else{
                // Pesan sesuai Activity Diagram jika Username/Password Salah
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/auth');
            }
        }else{
            $session->setFlashdata('msg', 'Username tidak ditemukan');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}