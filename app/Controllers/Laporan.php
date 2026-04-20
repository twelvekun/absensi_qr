<?php
namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KelasModel;

class Laporan extends BaseController
{
    protected $absensiModel;
    protected $kelasModel;

    public function __construct() {
        $this->absensiModel = new AbsensiModel();
        $this->kelasModel = new KelasModel();
    }

    // 1. HALAMAN LAPORAN ABSENSI SISWA
    public function siswa() {
        // Menangkap data dari form filter (jika ada)
        $filter_tanggal = $this->request->getGet('tanggal');
        $filter_kelas   = $this->request->getGet('id_kelas');

        $data = [
            'title'          => 'Laporan Absensi Siswa',
            'kelas'          => $this->kelasModel->findAll(), // Untuk dropdown filter
            'laporan'        => $this->absensiModel->getLaporanFiltered('siswa', $filter_tanggal, $filter_kelas),
            'filter_tanggal' => $filter_tanggal,
            'filter_kelas'   => $filter_kelas
        ];
        
        return view('laporan/siswa', $data);
    }

    // 2. HALAMAN LAPORAN ABSENSI GURU & STAF
    public function guru() {
        // Menangkap data dari form filter (jika ada)
        $filter_tanggal = $this->request->getGet('tanggal');

        $data = [
            'title'          => 'Laporan Absensi Guru & Staf',
            'laporan'        => $this->absensiModel->getLaporanFiltered('guru', $filter_tanggal),
            'filter_tanggal' => $filter_tanggal
        ];
        
        return view('laporan/guru', $data);
    }
}