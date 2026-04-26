<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $file_csv = FCPATH . 'kls9.csv'; 
        $id_kelas_default = 3; // Pastikan ini ID kelas yang benar

        if (($handle = fopen($file_csv, "r")) !== FALSE) {
            
            // 1. LEWATI BARIS HEADER (Sesuaikan dengan jumlah baris judul di Excel klien)
            // Jika judul hanya 1 baris, cukup panggil fgetcsv ini 1 kali. 
            fgetcsv($handle, 1000, ";"); // Aktifkan ini jika judul ada 2 baris
            fgetcsv($handle, 1000, ";"); 
            fgetcsv($handle, 1000, ";"); 
            // Aktifkan ini jika judul ada 3 baris

            $data_insert = [];
            $baris_ke = 1;

            // 2. KITA UBAH PEMISAHNYA MENJADI TITIK KOMA ( ; )
            while (($row = fgetcsv($handle, 1000, ";")) !== FALSE) {
                
                // --- FITUR DEBUGGING (Melihat isi baris pertama jika gagal) ---
                if ($baris_ke === 1 && empty($row[2])) {
                    echo "⚠️ PERINGATAN: Kolom nama (index 2) kosong.\n";
                    echo "Ini isi baris pertama yang terbaca sistem: \n";
                    print_r($row);
                    echo "Jika datanya menyatu, berarti pemisahnya bukan titik koma (;), silakan ganti menjadi koma (,)\n";
                }
                
                // Pastikan nama siswa (index 2) tidak kosong
                if(isset($row[2]) && trim($row[2]) != '') { 
                    $data_insert[] = [
                        'nis'              => isset($row[1]) ? trim($row[1]) : '',
                        'nama_lengkap'     => trim($row[2]),
                        'nisn'             => isset($row[3]) ? trim($row[3]) : '',
                        'jk'               => isset($row[4]) ? trim($row[4]) : '',
                        'tempat_tgl_lahir' => isset($row[5]) ? trim($row[5]) : '',
                        'agama'            => isset($row[6]) ? trim($row[6]) : '',
                        'alamat'           => isset($row[7]) ? trim($row[7]) : '',
                        'id_kelas'         => 5
                    ];
                }
                $baris_ke++;
            }
            fclose($handle);

            // 3. PENGAMAN (Cek apakah ada data sebelum melakukan Insert)
            if (!empty($data_insert)) {
                $this->db->table('siswa')->insertBatch($data_insert);
                echo "✅ SUKSES: " . count($data_insert) . " data siswa kelas " . $id_kelas_default . " berhasil diimport!\n";
            } else {
                echo "❌ GAGAL: File terbaca, tapi tidak ada data valid yang bisa dimasukkan.\n";
            }
            
        } else {
            echo "❌ GAGAL: File kls7.csv TIDAK DITEMUKAN di folder public!\n";
        }
    }
}