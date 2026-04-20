<?= view('layout/header', ['title' => 'Detail QR Code']) ?>
<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<style>
    .card-container { display: flex; gap: 20px; max-width: 800px; margin: 0 auto; align-items: flex-start;}
    .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); flex: 1; }
    .detail-info { text-align: left; background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;}
    .info-row { display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #ddd; font-size: 14px;}
    .info-label { color: #666; font-weight: 500;}
    .info-value { color: #333; font-weight: 600;}
    
    .qr-container { text-align: center; background: #fff; border: 2px dashed #4c9a2a; border-radius: 10px; padding: 20px; }
    .qr-container img { max-width: 100%; border-radius: 5px; margin-bottom: 15px;}
    .qr-title { font-weight: 600; color: #1e5631; margin-bottom: 5px;}
    
    .btn { padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-block; cursor: pointer; text-align: center; width: 100%; box-sizing: border-box;}
    .btn-back { background-color: #6c757d; color: white; margin-top: 15px; }
    .btn-download { background-color: #1e5631; color: white; margin-top: 10px;}
</style>

<div class="card-container">
    <div class="card">
        <h3 style="margin: 0 0 5px 0; color: #333;">Data Identitas</h3>
        <p style="margin: 0 0 20px 0; color: #777; font-size: 14px;">Terverifikasi di Sistem</p>

        <div class="detail-info">
            <div class="info-row">
                <span class="info-label">Nomor Identitas</span>
                <span class="info-value"><?= $profil['identitas'] ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value"><?= $profil['nama'] ?></span>
            </div>
            <div class="info-row" style="border-bottom: none;">
                <span class="info-label">Status / Posisi</span>
                <span class="info-value"><?= $profil['keterangan'] ?></span>
            </div>
        </div>
        
        <a href="<?= base_url('generateqr?jenis=' . $jenis) ?>" class="btn btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
    </div>

    <div class="card" style="max-width: 300px;">
        <div class="qr-container">
            <div class="qr-title">Kartu QR Code</div>
            <div style="font-size: 12px; color: #777; margin-bottom: 15px;">Reed-Solomon ECC Level H</div>
            
            <img src="<?= $qr_code ?>" alt="QR Code">
            
            <a href="<?= $qr_code ?>" download="<?= $profil['file_name'] ?>.png" class="btn btn-download">
                <i class="fas fa-download"></i> Unduh QR
            </a>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>