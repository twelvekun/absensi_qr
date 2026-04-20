<?php
namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\KelasModel;
use App\Models\AbsensiModel; // Tambahkan ini untuk mengakses tabel absensi

class Siswa extends BaseController
{
    protected $siswaModel;
    protected $kelasModel;
    protected $absensiModel;

    public function __construct() {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->absensiModel = new AbsensiModel(); // Inisialisasi model absensi
    }

    public function index() {
        $data = [
            'title' => 'Data Siswa',
            'siswa' => $this->siswaModel->getSiswaWithKelas()
        ];
        return view('siswa/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Tambah Data Siswa',
            'kelas' => $this->kelasModel->findAll()
        ];
        return view('siswa/create', $data);
    }

    public function store() {
        $this->siswaModel->save([
            'nis'          => $this->request->getPost('nis'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'id_kelas'     => $this->request->getPost('id_kelas'),
        ]);
        session()->setFlashdata('pesan', 'Data siswa berhasil ditambahkan.');
        return redirect()->to('/siswa');
    }

    public function show($id) {
        $data = [
            'title' => 'Detail Siswa',
            'siswa' => $this->siswaModel->getSiswaWithKelas($id)
        ];
        return view('siswa/show', $data);
    }
    public function edit($id) {
        $data = [
            'title' => 'Edit Data Siswa',
            'siswa' => $this->siswaModel->find($id),
            'kelas' => $this->kelasModel->findAll()
        ];
        return view('siswa/edit', $data);
    }

    public function update($id) {
        $this->siswaModel->update($id, [
            'nis'          => $this->request->getPost('nis'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'id_kelas'     => $this->request->getPost('id_kelas'),
        ]);
        session()->setFlashdata('pesan', 'Data siswa berhasil diubah.');
        return redirect()->to('/siswa');
    }

    public function delete($id) {
        // Langkah 1: Hapus semua data absensi milik siswa ini terlebih dahulu
        $this->absensiModel->where('id_siswa', $id)->delete();

        // Langkah 2: Setelah absensinya bersih, baru hapus data siswanya
        $this->siswaModel->delete($id);
        
        session()->setFlashdata('pesan', 'Data siswa beserta riwayat absensinya berhasil dihapus.');
        return redirect()->to('/siswa');
    }
}