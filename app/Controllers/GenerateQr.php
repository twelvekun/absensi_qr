<?php
namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\StafModel;

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
    protected $stafModel;

    public function __construct() {
        $this->siswaModel = new SiswaModel();
        $this->guruModel  = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->stafModel = new StafModel();
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
        elseif ($jenis == 'staf') {
            $data['data_list'] = $this->stafModel->findAll();
        }
            // (Nanti kamu bisa tambahkan logika untuk mengambil data staf di sini jika sudah siap)
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
        elseif ($jenis == 'staf') {
            $staf    = $this->stafModel->find($id);
            $data_qr = $staf['nip_staf'];
            $profil  = [
                'identitas'  => 'NIP: ' . $staf['nip_staf'],
                'nama'       => $staf['nama_staf'],
                'keterangan' => 'Staf / Tenaga Kependidikan',
                'file_name'  => 'QR_Staf_' . $staf['nip_staf']
            ];
        }

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