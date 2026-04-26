<?php
namespace App\Controllers;
use App\Models\KelasModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    
    public function __construct() {
        $this->kelasModel = new KelasModel();
    }

    // 1. Menampilkan Tabel (Index)
    public function index() {
        $data = [
            'title' => 'Data Kelas',
            'kelas' => $this->kelasModel->findAll()
        ];
        return view('kelas/index', $data);
    }

    // 2. Menampilkan Form Tambah (Create)
    public function create() {
        $data = [
            'title' => 'Tambah Data Kelas'
        ];
        return view('kelas/create', $data);
    }

    public function store() {
        $this->kelasModel->save([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat'    => $this->request->getPost('tingkat'),
        ]);
        session()->setFlashdata('pesan', 'Data kelas berhasil ditambahkan.');
        return redirect()->to('/kelas');
    }
    public function show($id) {
        $data = [
            'title' => 'Detail Kelas',
            'kelas' => $this->kelasModel->find($id)
        ];
        return view('kelas/show', $data);
    }
        public function edit($id) {
        $data = [
            'title' => 'Edit Data Kelas',
            'kelas' => $this->kelasModel->find($id)
        ];
        return view('kelas/edit', $data);
    }

    public function update($id) {
        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat'    => $this->request->getPost('tingkat'),
        ]);
        session()->setFlashdata('pesan', 'Data kelas berhasil diubah.');
        return redirect()->to('/kelas');
    }
        
    public function delete($id) {
        $this->kelasModel->delete($id);
        session()->setFlashdata('pesan', 'Data kelas berhasil dihapus.');
        return redirect()->to('/kelas');
    }
}