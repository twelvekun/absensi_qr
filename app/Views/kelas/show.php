<?= view('layout/header', ['title' => 'Detail Kelas']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 500px; margin: 0 auto; text-align: center;}
    .icon-placeholder { width: 90px; height: 90px; background-color: #e9ecef; color: #1e5631; border-radius: 15px; display: inline-flex; align-items: center; justify-content: center; font-size: 35px; margin-bottom: 20px;}
    .detail-info { text-align: left; background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;}
    .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #ddd; font-size: 14px;}
    .info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0;}
    .info-label { color: #666; font-weight: 500;}
    .info-value { color: #333; font-weight: 600;}
    
    .btn-back { background-color: #1e5631; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-block;}
</style>

<div class="card">
    <div class="icon-placeholder">
        <i class="fas fa-chalkboard"></i>
    </div>
    <h3 style="margin: 0 0 5px 0; color: #333;">Kelas <?= $kelas['nama_kelas'] ?></h3>
    <p style="margin: 0 0 20px 0; color: #777; font-size: 14px;">Informasi Detail Kelas</p>

    <div class="detail-info">
        <div class="info-row">
            <span class="info-label">ID Kelas Internal</span>
            <span class="info-value">#<?= $kelas['id_kelas'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tingkat</span>
            <span class="info-value"><?= $kelas['tingkat'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Nama Kelas</span>
            <span class="info-value"><?= $kelas['nama_kelas'] ?></span>
        </div>
    </div>

    <a href="<?= base_url('kelas') ?>" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Data Kelas</a>
</div>

<?= view('layout/footer') ?>