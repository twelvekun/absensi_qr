<?php
namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_pengguna';
    protected $allowedFields = ['nuptk', 'nama', 'username', 'password', 'role'];
}