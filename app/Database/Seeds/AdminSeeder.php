<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Menyiapkan data superadmin
        $data = [
            'nuptk'    => '12345678',
            'nama'     => 'Kepala TU',
            'username' => 'superadmin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'Superadmin'
        ];

        // Menyimpan data ke dalam tabel 'admin' menggunakan Query Builder
        $this->db->table('admin')->insert($data);
        
        echo "Data Superadmin berhasil ditambahkan ke database!\n";
    }
}