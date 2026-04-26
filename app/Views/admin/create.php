<?= view('layout/header', ['title' => 'Tambah Admin / Petugas']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card-form { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #444; font-size: 14px;}
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-family: 'Poppins', sans-serif; box-sizing: border-box; font-size: 14px;}
    .form-control:focus { outline: none; border-color: #4c9a2a; box-shadow: 0 0 5px rgba(76, 154, 42, 0.2);}
    
    .btn-submit { background: #1e5631; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-weight: 500; font-size: 14px; transition: 0.2s;}
    .btn-submit:hover { background: #143d22; }
    
    .btn-cancel { background: #6c757d; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-block; margin-left: 10px; transition: 0.2s;}
    .btn-cancel:hover { background: #5a6268; }

    .alert-info { background-color: #e2e3e5; color: #383d41; padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; border-left: 4px solid #6c757d; }
</style>

<div class="card-form">
    <h3 style="margin-top: 0; color: #333;"><i class="fas fa-user-plus"></i> Tambah Pengguna Baru</h3>
    <p style="color: #777; font-size: 13px; margin-bottom: 20px;">Tambahkan akun baru untuk memberikan hak akses pengelolaan sistem.</p>
    
    <div class="alert-info">
        <i class="fas fa-info-circle"></i> <strong>Catatan Keamanan:</strong> Password yang Anda masukkan di sini akan secara otomatis dienkripsi (Hash) oleh sistem sebelum disimpan ke database.
    </div>

    <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 25px;">

    <form action="<?= base_url('admin/store') ?>" method="POST">
        
        <?= csrf_field() ?>

        <div class="form-group">
            <label>NUPTK / NIP</label>
            <input type="text" name="nuptk" class="form-control" placeholder="Masukkan NUPTK atau NIP (opsional/jika ada)" autofocus>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso, S.Kom" required>
        </div>

        <div class="form-group">
            <label>Username (Untuk Login)</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username tanpa spasi" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
        </div>

        <div class="form-group">
            <label>Role / Hak Akses</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Hak Akses --</option>
                <option value="Superadmin">Superadmin (Kepala TU - Akses Penuh)</option>
                <option value="Petugas">Petugas (Staf TU - Terbatas)</option>
            </select>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Pengguna</button>
            <a href="<?= base_url('admin') ?>" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>