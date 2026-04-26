<?php
namespace App\Controllers;
use App\Models\AdminModel;

class Admin extends BaseController
{
    protected $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    // FUNGSI BLOKIR (Hanya Superadmin yang boleh masuk)
    private function cekSuperadmin() {
        if (session()->get('role') != 'Superadmin') {
            session()->setFlashdata('error', 'Akses Ditolak! Hanya Superadmin yang dapat mengakses menu ini.');
            return false;
        }
        return true;
    }

    public function index() {
        if (!$this->cekSuperadmin()) return redirect()->to('/dashboard'); // Lempar ke dashboard jika bukan Superadmin

        $data = [
            'title'    => 'Manajemen Admin & Petugas',
            'admin' => $this->adminModel->findAll()
        ];
        return view('admin/index', $data);
    }

    public function create() {
        if (!$this->cekSuperadmin()) return redirect()->to('/dashboard');

        $data = ['title' => 'Tambah Pengguna'];
        return view('admin/create', $data);
    }

    public function store() {
        if (!$this->cekSuperadmin()) return redirect()->to('/dashboard');

        $this->adminModel->save([
            'nuptk'        => $this->request->getPost('nuptk'),
            'nama' => $this->request->getPost('nama'),
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $this->request->getPost('role')
        ]);
        
        session()->setFlashdata('pesan', 'Data pengguna berhasil ditambahkan.');
        return redirect()->to('/admin');
    }
    public function edit($id) {
        if (!$this->cekSuperadmin()) return redirect()->to('/dashboard');

        $dataAdmin = $this->adminModel->find($id);

        if (empty($dataAdmin)) {
            session()->setFlashdata('error', 'Data pengguna tidak ditemukan.');
            return redirect()->to('/admin'); 
        }

        $data = [
            'title' => 'Ubah Data Pengguna',
            'admin' => $dataAdmin
        ];
        
        return view('admin/edit', $data);
    }

    public function update($id) {
        if (!$this->cekSuperadmin()) return redirect()->to('/dashboard');

        $passwordBaru = $this->request->getPost('password');
        $dataUpdate = [
            'nuptk'    => $this->request->getPost('nuptk'),
            'nama'     => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role')
        ];

        if (!empty($passwordBaru)) {
            $dataUpdate['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        // 4. Eksekusi update ke database
        $this->adminModel->update($id, $dataUpdate);
        
        session()->setFlashdata('pesan', 'Data pengguna berhasil diperbarui.');
        return redirect()->to('/admin');
    }

    public function delete($id) {
        if (!$this->cekSuperadmin()) return redirect()->to('/dashboard');

        // Cegah Superadmin menghapus dirinya sendiri
        if ($id == session()->get('id_pengguna')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
            return redirect()->to('/admin');
        }

        $this->adminModel->delete($id);
        session()->setFlashdata('pesan', 'Data pengguna berhasil dihapus.');
        return redirect()->to('/admin');
    }
}