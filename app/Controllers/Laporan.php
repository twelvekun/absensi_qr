<?php
namespace App\Controllers;

use App\Models\AbsensiModel;
use App\Models\KelasModel;
use App\Models\StafModel;
use Dompdf\Dompdf;
class Laporan extends BaseController
{
    protected $absensiModel;
    protected $kelasModel;
    protected $stafModel;

    public function __construct() {
        $this->absensiModel = new AbsensiModel();
        $this->kelasModel = new KelasModel();
        $this->stafModel = new StafModel();
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
        $filter_tanggal = $this->request->getGet('tanggal');
        $filter_jenis   = $this->request->getGet('jenis_pegawai'); // Menangkap filter Guru/Staf

        $data = [
            'title'          => 'Laporan Absensi Guru & Staf',
            // Kirim filter_jenis sebagai parameter ke-4 ke model
            'laporan'        => $this->absensiModel->getLaporanFiltered('guru', $filter_tanggal, null, $filter_jenis),
            'filter_tanggal' => $filter_tanggal,
            'filter_jenis'   => $filter_jenis
        ];
        
        return view('laporan/guru', $data);
    }
    public function edit($no_absen) {
        $db = \Config\Database::connect();
        $builder = $db->table('absensi');
        $builder->select('absensi.*, siswa.nama_lengkap as nama_siswa, guru.nama_guru, staf.nama_staf');
        $builder->join('siswa', 'siswa.id_siswa = absensi.id_siswa', 'left');
        $builder->join('guru', 'guru.id_guru = absensi.id_guru', 'left');
        $builder->join('staf', 'staf.id_staf = absensi.id_staf', 'left');
        $builder->where('no_absen', $no_absen);
        
        $data = [
            'title' => 'Ubah Data Absensi',
            'absen' => $builder->get()->getRowArray()
        ];

        return view('laporan/edit', $data);
    }

    public function update($no_absen) {
        $this->absensiModel->update($no_absen, [
            'masuk'            => $this->request->getPost('masuk'),
            'pulang'           => $this->request->getPost('pulang'),
            'status_kehadiran' => $this->request->getPost('status_kehadiran'),
            'keterangan'       => $this->request->getPost('keterangan')
        ]);

        session()->setFlashdata('pesan', 'Data absensi berhasil diperbarui!');
        // Mengembalikan user ke halaman sebelumnya (Laporan Siswa atau Guru)
        return redirect()->back();
    }
    public function cetakPdfSiswa()
    {
        // 1. Tangkap filter dari URL
        $tanggal  = $this->request->getGet('tanggal');
        $id_kelas = $this->request->getGet('id_kelas');
        $db = \Config\Database::connect();
        $builder = $db->table('absensi');
        $builder->select('absensi.*, siswa.nama_lengkap as nama_siswa, siswa.nis, kelas.nama_kelas');
        $builder->join('siswa', 'siswa.id_siswa = absensi.id_siswa');
        $builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        
        if (!empty($tanggal)) {
            $builder->where('absensi.tanggal', $tanggal);
        }
        if (!empty($id_kelas)) {
            $builder->where('siswa.id_kelas', $id_kelas);
        }
        $laporan = $builder->get()->getResultArray();

        // 3. Siapkan data untuk dikirim ke View PDF
        $data = [
            'title'   => 'Laporan Absensi Siswa',
            'laporan' => $laporan,
            'tanggal' => $tanggal
        ];

        // 4. Render HTML khusus PDF
        $html = view('laporan/pdf_siswa', $data);

        // 5. Konfigurasi dan Jalankan Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Kertas A4 posisi mendatar (Landscape) agar tabel muat
        $dompdf->render();
        
        // Attachment => false artinya PDF akan dibuka di tab baru (Preview), bukan otomatis terunduh
        $dompdf->stream("Laporan_Absensi_Siswa.pdf", ["Attachment" => false]);
    }
    public function cetakPdfGuru()
    {
        // 1. Tangkap parameter filter dari URL
        $tanggal       = $this->request->getGet('tanggal');
        $jenis_pegawai = $this->request->getGet('jenis_pegawai');
        $db = \Config\Database::connect();
        $builder = $db->table('absensi');
        // Ambil data absensi beserta data guru dan data staf (Left Join)
        $builder->select('absensi.*, guru.nama_guru, guru.nuptk, staf.nama_staf, staf.nip_staf');
        $builder->join('guru', 'guru.id_guru = absensi.id_guru', 'left');
        $builder->join('staf', 'staf.id_staf = absensi.id_staf', 'left');
        
        // Terapkan Filter Tanggal
        if (!empty($tanggal)) {
            $builder->where('absensi.tanggal', $tanggal);
        }
        
        // Terapkan Filter Jenis Pegawai (Guru atau Staf)
        if ($jenis_pegawai == 'guru') {
            $builder->where('absensi.id_guru IS NOT NULL');
        } elseif ($jenis_pegawai == 'staf') {
            $builder->where('absensi.id_staf IS NOT NULL');
        } else {
            // Jika memilih "Semua", tampilkan yang id_guru ADA atau id_staf ADA (kecualikan siswa)
            $builder->groupStart()
                    ->where('absensi.id_guru IS NOT NULL')
                    ->orWhere('absensi.id_staf IS NOT NULL')
                    ->groupEnd();
        }

        $laporan = $builder->get()->getResultArray();

        // 3. Siapkan data untuk dikirim ke View PDF
        $data = [
            'title'         => 'Laporan Absensi Guru dan Staf',
            'laporan'       => $laporan,
            'tanggal'       => $tanggal,
            'jenis_pegawai' => $jenis_pegawai
        ];

        // 4. Render HTML khusus PDF
        $html = view('laporan/pdf_guru', $data);

        // 5. Konfigurasi dan Jalankan Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Format mendatar
        $dompdf->render();
        
        // Tampilkan PDF di tab baru
        $dompdf->stream("Laporan_Absensi_Guru_Staf.pdf", ["Attachment" => false]);
    }
}