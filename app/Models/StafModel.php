<?php
namespace App\Models;
use CodeIgniter\Model;

class StafModel extends Model
{
    protected $table = 'staf';
    protected $primaryKey = 'id_staf';
    protected $allowedFields = ['nip_staf', 'nama_staf'];
}