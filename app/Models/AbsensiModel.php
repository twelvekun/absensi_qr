<?php
namespace App\Models;
use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'no_absen'; // Mengikuti nama kolom di database kamu
    
    // Memasukkan semua kolom persis sesuai database
    protected $allowedFields = [
        'id_siswa', 'id_guru', 'id_staf', 'hari', 'tanggal', 'masuk', 'pulang', 'id_pengguna','status_kehadiran', 'keterangan'
    ];
    // FUNGSI KHUSUS LAPORAN DENGAN FILTER
    // FUNGSI KHUSUS LAPORAN DENGAN FILTER
    public function getLaporanFiltered($jenis, $tanggal = null, $id_kelas = null, $filter_pegawai = null)
    {
        $builder = $this->db->table('absensi');
        
        // Tambahkan nama_staf dan nip_staf di bagian SELECT
        $builder->select('absensi.*, siswa.nama_lengkap as nama_siswa, siswa.nis, kelas.nama_kelas, guru.nama_guru, guru.nuptk, staf.nama_staf, staf.nip_staf');
        
        $builder->join('siswa', 'siswa.id_siswa = absensi.id_siswa', 'left');
        $builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas', 'left');
        $builder->join('guru', 'guru.id_guru = absensi.id_guru', 'left');
        // JOIN tabel staf (pastikan absensi.id_staf sesuai dengan kolom di databasemu)
        $builder->join('staf', 'staf.id_staf = absensi.id_staf', 'left'); 
        
        if ($jenis == 'siswa') {
            $builder->where('absensi.id_siswa IS NOT NULL');
            if (!empty($id_kelas)) {
                $builder->where('siswa.id_kelas', $id_kelas);
            }
        } elseif ($jenis == 'guru') {
            // Logika Filter untuk Laporan Guru & Staf
            if ($filter_pegawai == 'guru') {
                $builder->where('absensi.id_guru IS NOT NULL'); // Hanya Guru
            } elseif ($filter_pegawai == 'staf') {
                $builder->where('absensi.id_staf IS NOT NULL');  // Hanya Staf
            } else {
                // Default: Semua (Guru dan Staf)
                $builder->groupStart()
                        ->where('absensi.id_guru IS NOT NULL')
                        ->orWhere('absensi.id_staf IS NOT NULL')
                        ->groupEnd();
            }
        }

        if (!empty($tanggal)) {
            $builder->where('absensi.tanggal', $tanggal);
        }

        $builder->orderBy('absensi.tanggal', 'DESC');
        $builder->orderBy('absensi.masuk', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}