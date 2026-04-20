<?= view('layout/header', ['title' => 'Tambah Data Siswa']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto;}
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #333;}
    .form-control { width: 100%; padding: 10px 15px; border: 1.5px solid #ddd; border-radius: 6px; font-family: 'Poppins', sans-serif; font-size: 14px; box-sizing: border-box; transition: border-color 0.3s;}
    .form-control:focus { border-color: #4c9a2a; outline: none; }
    
    .btn-group { display: flex; gap: 10px; margin-top: 30px;}
    .btn { padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: 0.2s;}
    .btn-save { background-color: #1e5631; color: white; }
    .btn-save:hover { background-color: #143d22; }
    .btn-back { background-color: #6c757d; color: white; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;}
    .btn-back:hover { background-color: #5a6268; }
</style>

<div class="card">
    <h3 style="margin-top: 0; border-bottom: 2px solid #f4f7f6; padding-bottom: 15px;">Form Tambah Siswa Baru</h3>
    
    <form action="<?= base_url('siswa/store') ?>" method="post">
        <div class="form-group">
            <label>Nomor Induk Siswa (NIS)</label>
            <input type="text" name="nis" class="form-control" placeholder="Contoh: 101234" required autofocus>
        </div>
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap siswa" required>
        </div>
        
        <div class="form-group">
            <label>Pilih Kelas</label>
            <select name="id_kelas" class="form-control" required>
                <option value="">-- Pilih Tingkat & Kelas --</option>
                <?php foreach($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>"><?= $k['tingkat'] ?> - <?= $k['nama_kelas'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="btn-group">
            <a href="<?= base_url('siswa') ?>" class="btn btn-back">Kembali</a>
            <button type="submit" class="btn btn-save"><i class="fas fa-save"></i> Simpan Data</button>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>