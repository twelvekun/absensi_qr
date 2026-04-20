<?php
namespace App\Models;
use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'no_absen'; // Mengikuti nama kolom di database kamu
    
    // Memasukkan semua kolom persis sesuai database
    protected $allowedFields = [
        'id_siswa', 'id_guru', 'id_staf', 'hari', 'tanggal', 'masuk', 'pulang', 'id_pengguna'
    ];
    // FUNGSI KHUSUS LAPORAN DENGAN FILTER
    public function getLaporanFiltered($jenis, $tanggal = null, $id_kelas = null)
    {
        $builder = $this->db->table('absensi');
        $builder->select('absensi.*, siswa.nama_lengkap as nama_siswa, siswa.nis, kelas.nama_kelas, guru.nama_guru, guru.nuptk');
        
        $builder->join('siswa', 'siswa.id_siswa = absensi.id_siswa', 'left');
        $builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas', 'left');
        $builder->join('guru', 'guru.id_guru = absensi.id_guru', 'left');
        
        // Memisahkan query berdasarkan jenis laporan yang diminta
        if ($jenis == 'siswa') {
            $builder->where('absensi.id_siswa IS NOT NULL'); // Hanya tarik data siswa
            
            // Jika filter kelas dipilih
            if (!empty($id_kelas)) {
                $builder->where('siswa.id_kelas', $id_kelas);
            }
        } elseif ($jenis == 'guru') {
            // Tarik data guru (atau staf jika ada)
            $builder->groupStart()
                    ->where('absensi.id_guru IS NOT NULL')
                    ->orWhere('absensi.id_staf IS NOT NULL')
                    ->groupEnd();
        }

        // Jika filter tanggal diisi
        if (!empty($tanggal)) {
            $builder->where('absensi.tanggal', $tanggal);
        }

        $builder->orderBy('absensi.tanggal', 'DESC');
        $builder->orderBy('absensi.masuk', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}