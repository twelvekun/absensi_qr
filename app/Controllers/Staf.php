<?php
namespace App\Controllers;
use App\Models\StafModel;

class Staf extends BaseController
{
    protected $stafModel;

    public function __construct() {
        $this->stafModel = new StafModel();
    }

    // 1. Menampilkan Tabel
    public function index() {
        $data = [
            'title' => 'Data Staf',
            'staf'  => $this->stafModel->findAll()
        ];
        return view('staf/index', $data);
    }

    // 2. Menampilkan Form Tambah
    public function create() {
        $data = [
            'title' => 'Tambah Data Staf'
        ];
        return view('staf/create', $data);
    }

    // 3. Memproses Form Tambah
    public function store() {
        $this->stafModel->save([
            'nip'     => $this->request->getPost('nip'),
            'nama_staf' => $this->request->getPost('nama_staf'),
        ]);
        session()->setFlashdata('pesan', 'Data staf berhasil ditambahkan.');
        return redirect()->to('/staf');
    }
    public function edit($id) {
        $data = [
            'title' => 'Edit Data Staf',
            'staf' => $this->stafModel->find($id)
        ];
        return view('staf/edit', $data);
    }

    public function update($id) {
        $this->stafModel->update($id, [
            'nip'     => $this->request->getPost('nip'),
            'nama_staf' => $this->request->getPost('nama_staf'),
        ]);
        session()->setFlashdata('pesan', 'Data staf berhasil diubah.');
        return redirect()->to('/staf');
    }

    // 4. Menampilkan Detail
    public function show($id) {
        $data = [
            'title' => 'Detail Staf',
            'staf'  => $this->stafModel->find($id)
        ];
        return view('staf/show', $data);
    }

    // 5. Menghapus Data
    public function delete($id) {
        $this->stafModel->delete($id);
        session()->setFlashdata('pesan', 'Data staf berhasil dihapus.');
        return redirect()->to('/staf');
    }
}