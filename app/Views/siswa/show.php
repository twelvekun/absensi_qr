<?= view('layout/header', ['title' => 'Detail Siswa']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 500px; margin: 0 auto; text-align: center;}
    .avatar-placeholder { width: 100px; height: 100px; background-color: #e9ecef; color: #1e5631; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 40px; margin-bottom: 20px;}
    .detail-info { text-align: left; background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;}
    .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #ddd; font-size: 14px;}
    .info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0;}
    .info-label { color: #666; font-weight: 500;}
    .info-value { color: #333; font-weight: 600;}
    
    .btn-back { background-color: #1e5631; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-block; transition: 0.2s;}
    .btn-back:hover { background-color: #143d22; }
</style>

    <div class="card">
        <div class="avatar-placeholder">
        <i class="fas fa-chalkboard-teacher"></i>
    </div>
        <h3 style="margin: 0 0 5px 0; color: #333;">Profil Siswa</h3>
        <p style="margin: 0 0 20px 0; color: #777; font-size: 14px;">Data Identitas Lengkap</p>

        <div class="detail-info">
            <div class="info-row">
                <span class="info-label">Nomor Induk Siswa (NIS)</span>
                <span class="info-value"><?= $siswa['nis'] ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value"><?= $siswa['nama_lengkap'] ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Tingkat / Kelas</span>
                <span class="info-value"><?= $siswa['tingkat'] ?> - <?= $siswa['nama_kelas'] ?></span>
            </div>
        </div>
        
        <a href="<?= base_url('siswa') ?>" class="btn btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Data Siswa</a>
    </div>

<?= view('layout/footer') ?>