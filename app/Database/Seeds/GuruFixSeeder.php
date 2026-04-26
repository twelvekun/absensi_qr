<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class GuruFixSeeder extends Seeder
{
    public function run()
    {
        // Daftar nama guru dari klien
        $daftar_nama = [
            "Ilman Zuhri, M.Pd.I",
            "Lukman Hakim, M. Sosio",
            "Drs. Shohif",
            "Uman, S.Pd",
            "H. Sutrisno, S.Pd",
            "H. Moh. Romli Tamam, S.Ag, M.Pd.I",
            "Afandi, S.Pd",
            "Toni Wahyudi, S.Pd",
            "Arifin, S. Kom",
            "Dra. Siti Fatimah, S.Sn",
            "Hj.Pujiati, S.Pd",
            "Qurrotul Ainiyah, S.Pd.I",
            "Noviana S. S.Pd.I",
            "Faradilla Istighfarah, S.Pd",
            "Wahyumatul Chusnah, S.Pd",
            "Moh. Rifa'I, S.Pd.I",
            "A. Habiburrahman, S.Pd.I",
            "Suci Damayanti, S.Pd",
            "Indah Sulistyo Wati, S.HI",
            "Drs. H. Ah. Nurul Huda",
            "Drs. H. Nur Qomari",
            "Umu Afiyah, S. Pd",
            "Khoirul Huda, S. PdI",
            "H. Waji, S. Pd",
            "Laily Sanjaya, S.Pd",
            "Muyasaro Aini, S. Pd",
            "Rohmania Rista, S. Pd",
            "Khidlotul Khofifah, S.Pd",
            "Khumaidah Wahyu Putri Hutami, S.T.I"
        ];

        $data_insert = [];
        $no = 1;

        // Looping untuk merakit data
        foreach ($daftar_nama as $nama) {
            $data_insert[] = [
                'nama_guru'        => trim($nama),
                // Membuat ID unik otomatis: GURU001, GURU002, dst.
                'nuptk'            => 'GURU' . str_pad($no, 3, '0', STR_PAD_LEFT), 
            ];
            $no++;
        }

        // Eksekusi insert massal ke tabel 'guru'
        if (!empty($data_insert)) {
            $this->db->table('guru')->insertBatch($data_insert);
            echo "✅ SUKSES: " . count($data_insert) . " Data Guru berhasil ditambahkan!\n";
        }
    }
}