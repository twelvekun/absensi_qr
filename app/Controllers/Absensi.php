<?php
namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;
// use App\Models\StafModel; // (Aktifkan ini jika Anda sudah membuat StafModel)

class Absensi extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $guruModel;

    public function __construct() {
        $this->absensiModel = new AbsensiModel();
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
    }

    // 1. Menampilkan Halaman Kamera Scanner
    public function scan() {
        $data = ['title' => 'Scan Kehadiran'];
        return view('absensi/scan', $data);
    }

   public function proses_scan() {
        $qr_data = $this->request->getPost('qr_data');
        $tanggal_hari_ini = date('Y-m-d');
        $waktu_sekarang = date('H:i:s');

        $daftar_hari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $hari_ini = $daftar_hari[date('l')];

        // --- MENGAMBIL ID ADMIN YANG SEDANG MENGOPERASIKAN SCANNER ---
        // (Asumsi saat login, kamu menyimpan id_pengguna di session)
        $id_pengguna_login = session()->get('id_pengguna'); 

        // ==========================================
        // CEK 1: LOGIKA UNTUK SISWA
        // ==========================================
        $siswa = $this->siswaModel->where('nis', $qr_data)->first();
        if ($siswa) {
            $cekAbsen = $this->absensiModel->where(['id_siswa' => $siswa['id_siswa'], 'tanggal' => $tanggal_hari_ini])->first();
            
            if ($cekAbsen) {
                // Jika sudah ada data, cek apakah kolom 'pulang' kosong atau berisi '00:00:00'
                if (empty($cekAbsen['pulang']) || $cekAbsen['pulang'] == '00:00:00') {
                    // Pakai 'no_absen' sebagai primary key untuk mengupdate data
                    $this->absensiModel->update($cekAbsen['no_absen'], [
                        'pulang' => $waktu_sekarang
                    ]);
                    return $this->response->setJSON(['status' => 'success', 'title' => 'Absen PULANG Berhasil!', 'nama' => $siswa['nama_lengkap'], 'role' => 'Siswa']);
                } else {
                    return $this->response->setJSON(['status' => 'warning', 'message' => $siswa['nama_lengkap'] . ' sudah melakukan absen Masuk dan Pulang hari ini.']);
                }
            } else {
                // Insert absen MASUK
                $this->absensiModel->save([
                    'id_siswa'    => $siswa['id_siswa'],
                    'id_guru'     => null,
                    'idstaf'      => null,
                    'hari'        => $hari_ini,
                    'tanggal'     => $tanggal_hari_ini,
                    'masuk'       => $waktu_sekarang,
                    'id_pengguna' => $id_pengguna_login
                ]);
                return $this->response->setJSON(['status' => 'success', 'title' => 'Absen MASUK Berhasil!', 'nama' => $siswa['nama_lengkap'], 'role' => 'Siswa']);
            }
        }

        // ==========================================
        // CEK 2: LOGIKA UNTUK GURU
        // ==========================================
        $guru = $this->guruModel->where('nuptk', $qr_data)->first();
        if ($guru) {
            $cekAbsen = $this->absensiModel->where(['id_guru' => $guru['id_guru'], 'tanggal' => $tanggal_hari_ini])->first();
            
            if ($cekAbsen) {
                if (empty($cekAbsen['pulang']) || $cekAbsen['pulang'] == '00:00:00') {
                    $this->absensiModel->update($cekAbsen['no_absen'], [
                        'pulang' => $waktu_sekarang
                    ]);
                    return $this->response->setJSON(['status' => 'success', 'title' => 'Absen PULANG Berhasil!', 'nama' => $guru['nama_guru'], 'role' => 'Guru']);
                } else {
                    return $this->response->setJSON(['status' => 'warning', 'message' => $guru['nama_guru'] . ' sudah melakukan absen Masuk dan Pulang hari ini.']);
                }
            } else {
                $this->absensiModel->save([
                    'id_siswa'    => null,
                    'id_guru'     => $guru['id_guru'],
                    'idstaf'      => null,
                    'hari'        => $hari_ini,
                    'tanggal'     => $tanggal_hari_ini,
                    'masuk'       => $waktu_sekarang,
                    'id_pengguna' => $id_pengguna_login
                ]);
                return $this->response->setJSON(['status' => 'success', 'title' => 'Absen MASUK Berhasil!', 'nama' => $guru['nama_guru'], 'role' => 'Guru']);
            }
        }

        // ==========================================
        // (Nanti logika Staf bisa kamu tambahkan di bawah sini mirip dengan Guru)
        // ==========================================

        return $this->response->setJSON(['status' => 'error', 'message' => 'QR Code tidak terdaftar di sistem.']);
    }
}