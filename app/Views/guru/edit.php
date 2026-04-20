<?= view('layout/header', ['title' => $title]) ?>
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
</style>

<div class="card-form">
    <h3 style="margin-top: 0; color: #333;"><i class="fas fa-user-edit"></i> Edit Data Guru</h3>
    <p style="color: #777; font-size: 13px; margin-bottom: 20px;">Silakan ubah data identitas guru pada form di bawah ini.</p>
    
    <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 25px;">

    <form action="<?= base_url('guru/update/' . $guru['id_guru']) ?>" method="POST">
        
        <?= csrf_field() ?>

        <div class="form-group">
            <label>NUPTK / NIP</label>
            <input type="text" name="nuptk" class="form-control" value="<?= $guru['nuptk'] ?>" required>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_guru" class="form-control" value="<?= $guru['nama_guru'] ?>" required>
        </div>


        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="<?= base_url('guru') ?>" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>