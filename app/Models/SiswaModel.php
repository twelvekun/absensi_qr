<?php
namespace App\Models;
use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $allowedFields = ['nis', 'nama_lengkap', 'id_kelas'];

    // Fungsi ini sekarang bisa mengambil semua data, atau satu data jika $id diisi
    public function getSiswaWithKelas($id = false)
    {
        if ($id === false) {
            return $this->select('siswa.*, kelas.nama_kelas, kelas.tingkat')
                        ->join('kelas', 'kelas.id_kelas = siswa.id_kelas')
                        ->findAll();
        }

        return $this->select('siswa.*, kelas.nama_kelas, kelas.tingkat')
                    ->join('kelas', 'kelas.id_kelas = siswa.id_kelas')
                    ->where('siswa.id_siswa', $id)
                    ->first();
    }
}