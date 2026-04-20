<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        
        // Cek apakah user sudah login. Jika belum, tendang kembali ke halaman login
        if(!$session->get('logged_in')){
            $session->setFlashdata('msg', 'Silakan login terlebih dahulu!');
            return redirect()->to('/auth');
        }
        
        // Mengambil data nama dan role dari session untuk ditampilkan
        $data = [
            'nama' => $session->get('nama'),
            'role' => $session->get('role')
        ];
        
        return view('dashboard_view', $data);
    }
}