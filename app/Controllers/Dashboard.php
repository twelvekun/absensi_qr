<?php
namespace App\Controllers;
use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\StafModel;
use App\Models\AbsensiModel;

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
        
        $siswaModel   = new SiswaModel();
        $guruModel    = new GuruModel();
        $stafModel    = new StafModel();
        $absensiModel = new AbsensiModel();

        // 1. MENGHITUNG TOTAL DATA MASTER
        $total_siswa = $siswaModel->countAllResults();
        $total_guru  = $guruModel->countAllResults();
        $total_staf  = $stafModel->countAllResults();

        // 2. MENGHITUNG TOTAL KEHADIRAN HARI INI
        $hari_ini = date('Y-m-d');
        $hadir_hari_ini = $absensiModel->where('tanggal', $hari_ini)->countAllResults();

        // 3. MENGHITUNG TINGKAT KEHADIRAN (PERSENTASE)
        $total_personel = $total_siswa + $total_guru + $total_staf;
        
        // Mencegah error pembagian dengan nol (Division by Zero) jika database masih kosong
        if ($total_personel > 0) {
            $persentase_hadir = round(($hadir_hari_ini / $total_personel) * 100, 1);
        } else {
            $persentase_hadir = 0;
        }

        // 4. MENGIRIM DATA KE VIEW
        $data = [
            'title'            => 'Dashboard Utama',
            'total_siswa'      => $total_siswa,
            'total_guru'       => $total_guru,
            'total_staf'       => $total_staf,
            'hadir_hari_ini'   => $hadir_hari_ini,
            'persentase_hadir' => $persentase_hadir
        ];
        return view('dashboard_view', $data);
    }

}