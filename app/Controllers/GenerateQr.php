<?php
namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;

// Import library Endroid v5
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;

class GenerateQr extends BaseController
{
    protected $siswaModel;
    protected $guruModel;
    protected $kelasModel;

    public function __construct() {
        $this->siswaModel = new SiswaModel();
        $this->guruModel  = new GuruModel();
        $this->kelasModel = new KelasModel();
    }

    // 1. HALAMAN UTAMA (Tabel dan Filter)
    public function index() {
        // Tangkap parameter filter (default 'siswa' jika kosong)
        $jenis    = $this->request->getGet('jenis') ?? 'siswa';
        $id_kelas = $this->request->getGet('id_kelas');

        $data = [
            'title'    => 'Generate QR Code',
            'jenis'    => $jenis,
            'id_kelas' => $id_kelas,
            'kelas'    => $this->kelasModel->findAll(),
            'data_list'=> []
        ];

        // Logika Pengambilan Data Berdasarkan Filter
        if ($jenis == 'siswa') {
            if (!empty($id_kelas)) {
                $data['data_list'] = $this->siswaModel->select('siswa.*, kelas.nama_kelas, kelas.tingkat')
                                        ->join('kelas', 'kelas.id_kelas = siswa.id_kelas')
                                        ->where('siswa.id_kelas', $id_kelas)
                                        ->findAll();
            } else {
                $data['data_list'] = $this->siswaModel->getSiswaWithKelas();
            }
        } elseif ($jenis == 'guru') {
            $data['data_list'] = $this->guruModel->findAll();
        }
        // (Nanti kamu bisa tambah elseif ($jenis == 'staf') jika tabel staf sudah siap)

        return view('qrcode/index', $data);
    }

    // 2. HALAMAN TAMPILKAN QR CODE (Pengganti siswa/show)
    public function show($jenis, $id) {
        $data_qr = '';
        $profil  = [];

        // Menyiapkan data berdasarkan jenis aktor
        if ($jenis == 'siswa') {
            $siswa   = $this->siswaModel->getSiswaWithKelas($id);
            $data_qr = $siswa['nis'];
            $profil  = [
                'identitas'  => 'NIS: ' . $siswa['nis'],
                'nama'       => $siswa['nama_lengkap'],
                'keterangan' => 'Kelas: ' . $siswa['tingkat'] . ' - ' . $siswa['nama_kelas'],
                'file_name'  => 'QR_Siswa_' . $siswa['nis']
            ];
        } elseif ($jenis == 'guru') {
            $guru    = $this->guruModel->find($id);
            $data_qr = $guru['nuptk'];
            $profil  = [
                'identitas'  => 'NUPTK: ' . $guru['nuptk'],
                'nama'       => $guru['nama_guru'],
                'keterangan' => 'Guru / Tenaga Pendidik',
                'file_name'  => 'QR_Guru_' . $guru['nuptk']
            ];
        }

        // --- IMPLEMENTASI ALGORITMA REED-SOLOMON VERSI 5 ---
        $qrCode = new QrCode(
            data: $data_qr,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 250,
            margin: 10
        );

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $data = [
            'title'   => 'Cetak QR Code',
            'profil'  => $profil,
            'qr_code' => $result->getDataUri(),
            'jenis'   => $jenis
        ];
        
        return view('qrcode/show', $data);
    }
}