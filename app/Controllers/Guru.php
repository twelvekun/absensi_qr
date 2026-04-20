<?php
namespace App\Controllers;
use App\Models\GuruModel;

class Guru extends BaseController
{
    protected $guruModel;

    public function __construct() {
        $this->guruModel = new GuruModel();
    }

    // 1. Menampilkan Tabel
    public function index() {
        $data = [
            'title' => 'Data Guru',
            'guru'  => $this->guruModel->findAll()
        ];
        return view('guru/index', $data);
    }

    // 2. Menampilkan Form Tambah
    public function create() {
        $data = [
            'title' => 'Tambah Data Guru'
        ];
        return view('guru/create', $data);
    }

    // 3. Memproses Form Tambah
    public function store() {
        $this->guruModel->save([
            'nuptk'     => $this->request->getPost('nuptk'),
            'nama_guru' => $this->request->getPost('nama_guru'),
        ]);
        session()->setFlashdata('pesan', 'Data guru berhasil ditambahkan.');
        return redirect()->to('/guru');
    }
    public function edit($id) {
        $data = [
            'title' => 'Edit Data Guru',
            'guru' => $this->guruModel->find($id)
        ];
        return view('guru/edit', $data);
    }

    public function update($id) {
        $this->guruModel->update($id, [
            'nuptk'     => $this->request->getPost('nuptk'),
            'nama_guru' => $this->request->getPost('nama_guru'),
        ]);
        session()->setFlashdata('pesan', 'Data guru berhasil diubah.');
        return redirect()->to('/guru');
    }

    // 4. Menampilkan Detail
    public function show($id) {
        $data = [
            'title' => 'Detail Guru',
            'guru'  => $this->guruModel->find($id)
        ];
        return view('guru/show', $data);
    }

    // 5. Menghapus Data
    public function delete($id) {
        $this->guruModel->delete($id);
        session()->setFlashdata('pesan', 'Data guru berhasil dihapus.');
        return redirect()->to('/guru');
    }
}